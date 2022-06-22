const Api = {
    Auth: {}, 
    Collab: {}, 
    Task: {}, 
    SubTask: {}, 
};
(() => {
    $.ajaxSetup({
        headers: { 
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
        },
        crossDomain: true
    });
})();


//Auth
(() => {
    // Đăng kí
    Api.Auth.Register = (data) => $.ajax({
        url: `/customer/api/auth/register`,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
    });
    // Đăng nhập
    Api.Auth.Login = (data) => $.ajax({
        url: `/customer/api/auth/login`,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
    });
    // Đăng xuất
    Api.Auth.Logout = (data) => $.ajax({
        url: `/customer/api/auth/logout`,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
    });
})();
 
//Collab
(() => {
    Api.Collab.GetAll = () => $.ajax({
        url: `/customer/api/collab/get`,
        method: 'GET',
    });
    // Lấy ra collab có thể assign task
    Api.Collab.GetAssign = () => $.ajax({
        url: `/customer/api/collab/get-assign`,
        method: 'GET',
    });
    // Gửi lời mời
    Api.Collab.Sending = (data) => $.ajax({
        url: `/customer/api/collab/sending`,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
    }); 
})();
 

//Task
(() => {
    // lấy ra tất cả các task
    Api.Task.GetAll = () => $.ajax({
        url: `/customer/api/task/get`,
        method: 'GET',
    });
    // lấy ra 1 task
    Api.Task.GetOne = (id) => $.ajax({
        url: `/customer/api/task/get-one`,
        method: 'GET',
        dataType: 'json',
        data: {
            id: id ?? '', 
        }
    });
    // Tạo mới
    Api.Task.Create = (data) => $.ajax({
        url: `/customer/api/task/create`,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
    }); 
    // Cập nhật
    Api.Task.Update = (data) => $.ajax({
        url: `/customer/api/task/update`,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
    }); 
})();

//SubTask
(() => { 
    // lấy ra tất cả các sub task
    Api.SubTask.GetAll = (id) => $.ajax({
        url: `/customer/api/subtask/get`,
        method: 'GET',
        dataType: 'json',
        data: {
            id: id ?? '', 
        }
    });
    // Tạo mới
    Api.SubTask.Create = (data) => $.ajax({
        url: `/customer/api/subtask/create`,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
    }); 
    // Cập nhật trạng thái
    Api.SubTask.Update = (id, task_id) => $.ajax({
        url: `/customer/api/subtask/update`,
        method: 'GET',
        dataType: 'json',
        data: {
            id: id ?? '', 
            task_id: task_id ?? '', 
        }
    });
    // xóa sub task
    Api.SubTask.Delete = (id, task_id) => $.ajax({
        url: `/customer/api/subtask/delete`,
        method: 'GET',
        dataType: 'json',
        data: {
            id: id ?? '', 
            task_id: task_id ?? '', 
        }
    });
})();