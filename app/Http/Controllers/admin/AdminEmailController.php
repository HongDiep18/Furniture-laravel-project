<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\SendCustomEmail;
use App\Models\EmailLog;
use App\Models\EmailTemplate;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PharIo\Manifest\Email;

class AdminEmailController extends Controller
{

    public function emailSubscribers(Request $request)
    {
        $query = Subscriber::query();
        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->name . '%')
                    ->orWhere('name', 'like', '%' . $request->name . '%');
            });
        }
        $perPage = (int) $request->input('per_page', 10);
        $subscribers = $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->all());

        return view('admin.pages.email.user-subscribers', compact('subscribers'));
    }

    public function changeStatus(Request $request)
    {
        try {
            $subscriber = Subscriber::findOrFail($request->id);
            $subscriber->status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $subscriber->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => true]);
        }
    }

    public function deleteEmailSubscribers($subscriberId)
    {
        $subscriber = Subscriber::findOrFail($subscriberId);
        try {
            $subscriber->delete();
            return redirect()->back()->with('success', 'Đã xóa email!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa email. Vui lòng thử lại!');
        }
    }

    public function templates(Request $request)
    {
        $query = EmailTemplate::query();

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('subject', 'like', '%' . $request->name . '%');
            });
        }
        $perPage = (int) $request->input('per_page', 10);
        $templates = $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->all());

        return view('admin.pages.email.email-template.templates', compact('templates'));
    }

    public function addTemplate()
    {

        return view('admin.pages.email.email-template.add-template');
    }

    public function storeTemplate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'subject' => 'required|string',
            'content' => 'required|string',
        ], [
            'name.required' => 'Tên không được bỏ trống.',
            'subject.required' => 'Tiêu đề không được bỏ trống.',
            'content.required' => 'Nội dung không được bỏ trống.',
        ]);

        try {
            EmailTemplate::create($validated);
            return redirect()->route('admin.email.templates')->with('success', 'Tạo mẫu email thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.email.templates')->with('error', 'Có lỗi xảy ra khi tạo mẫu email. Vui lòng thử lại!');
        }
    }

    public function editTemplate($templateId)
    {
        $template = EmailTemplate::findOrFail($templateId);
        return view('admin.pages.email.email-template.edit-template', compact('template'));
    }

    public function updateTemplate(Request $request, $templateId)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'subject' => 'required|string',
            'content' => 'required|string',
        ], [
            'name.required' => 'Tên không được bỏ trống.',
            'subject.required' => 'Tiêu đề không được bỏ trống.',
            'content.required' => 'Nội dung không được bỏ trống.',
        ]);

        try {
            $template = EmailTemplate::findOrFail($templateId);
            $template->update($validated);
            return redirect()->route('admin.email.templates')->with('success', 'Sửa mẫu email thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.email.templates')->with('error', 'Có lỗi xảy ra khi sửa email. Vui lòng thử lại!');
        }
    }

    public function deleteTemplate($templateId)
    {
        $template = EmailTemplate::findOrFail($templateId);
        try {
            $template->delete();
            return redirect()->back()->with('success', 'Đã xóa mẫu email!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa mẫu email. Vui lòng thử lại!');
        }
    }

    public function emailDetail($templateId)
    {
        $template = EmailTemplate::findOrFail($templateId);
        return view('admin.pages.email.send-email', compact('template'));
    }

    public function sendEmail(Request $request, $templateId)
    {
        $request->validate([
            'send_to' => 'required|in:user,subscriber,both',
        ]);
        $template = EmailTemplate::findOrFail($templateId);

        if ($request->send_to == 'user' || $request->send_to == 'both') {
            $users = User::where('role', 2)->get();
            foreach ($users as $user) {
                $this->sendAndLogEmail($user->email, $template, $user->id, null);
            }
        }
        if ($request->send_to == 'subscriber' || $request->send_to == 'both') {
            $subscribers = Subscriber::all();
            foreach ($subscribers as $sub) {
                if($sub->status) {
                    $this->sendAndLogEmail($sub->email, $template, null, $sub->id);
                }
            }
        }

        return redirect()->route('admin.email.templates')->with('success', 'Đã gửi email!');
    }

    private function sendAndLogEmail($email, $template, $user_id = null, $subscriber_id = null)
    {
        try {
            Mail::to($email)->send(new SendCustomEmail($template->subject, $template->content));

            EmailLog::create([
                'recipient_email' => $email,
                'user_id' => $user_id,
                'subscriber_id' => $subscriber_id,
                'template_id' => $template->id,
                'subject' => $template->subject,
                'content' => $template->content,
                'status' => 'sent',
                'error_message' => null
            ]);
        } catch (\Exception $e) {
            EmailLog::create([
                'recipient_email' => $email,
                'user_id' => $user_id,
                'subscriber_id' => $subscriber_id,
                'template_id' => $template->id,
                'subject' => $template->subject,
                'content' => $template->content,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }

    public function logs (Request $request) {
        $query = EmailLog::query();

        if($request->filled('name')) {
            $query->where('recipient_email','like', '%' . $request->name . '%');
        }
        if ($request->filled('subject')) {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }
        if ($request->filled('status')) {
            $query->where('status',  $request->status);
        }

        $perPage = (int) $request->input('per_page', 10);
        $logs = $query->orderBy('updated_at', 'desc')->paginate($perPage)->appends($request->all());

        return view('admin.pages.email.email-log', compact('logs'));
    }

    public function deleteLog($logId)
    {
        $log = EmailLog::findOrFail($logId);
        try {
            $log->delete();
            return redirect()->back()->with('success', 'Đã xóa mẫu email!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa mẫu email. Vui lòng thử lại!');
        }
    }

    public function logDetail($logId) {
        $log = EmailLog::findOrFail($logId);
        return view('admin.pages.email.mail-detail', compact('log'));
    }

    public function retry($logId) {
        $log = EmailLog::findOrFail($logId);
        try {
            Mail::to($log->recipient_email)->send(new SendCustomEmail($log->subject, $log->content));

            $log->update([
                'status' => 'sent',
                'error_message' => null,
            ]);
            return redirect()->route('admin.email.logs')->with('success', 'Đã gửi email!');
        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            return redirect()->route('admin.email.logs')->with('error', 'Lỗi!');
        }
    }
}
