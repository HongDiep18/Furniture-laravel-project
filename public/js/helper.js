function convertToAlias(str) {
    // Chuyển thành chữ thường
    str = str.toLowerCase();

    // Thay thế các ký tự có dấu thành không dấu
    str = str.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    str = str.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    str = str.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    str = str.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    str = str.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    str = str.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    str = str.replace(/đ/gi, 'd');

    // Thay thế khoảng trắng bằng dấu gạch ngang
    str = str.replace(/\s+/g, '-');

    // Loại bỏ các ký tự đặc biệt
    str = str.replace(/[^a-z0-9-]/g, '');

    // Loại bỏ nhiều dấu gạch ngang liên tiếp
    str = str.replace(/-+/g, '-');

    // Loại bỏ dấu gạch ngang ở đầu và cuối
    str = str.replace(/^-+|-+$/g, '');

    return str;
}