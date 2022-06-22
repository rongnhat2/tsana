// View
const View = {
    Invite: {
        render(data){
            data.map((v, k) => {
                $(".I-main .collab-list")
                    .prepend(`<div class="collab-item-block">
                                <div class="collab-item">
                                    <div class="collab-avatar"> </div>
                                    <div class="collab-email">
                                        ${v.email}
                                    </div>
                                    <div class="collab-name">
                                        ${v.name}
                                    </div>
                                    ${v.status == 0 ? `<div class="collab-status"> Pending </div>` : ``}
                                </div>
                            </div> `)
                if (k < 4) {
                    $('aside .collab-list')
                        .append(`<div class="collab-item"> </div>`)
                }
            })
        },
        setDefaul(){
            var resource = "#invite-form";
            $(`${resource}`).find('.data-email').val(""); 
        },
        getVal(){
            var resource = "#invite-form";
            var fd = new FormData();
            var required_data = [];
            var onPushData = true;

            var data_email      = $(`${resource}`).find('.data-email').val(); 

            if (View.validateEmail(data_email) == null) { 
                if (data_email == '') { 
                    required_data.push('Email is required.'); onPushData = false 
                }else{
                    required_data.push('Email is not valid.'); onPushData = false 
                }
            } 
            
            if (onPushData) {
                fd.append('data_email', data_email);  
                return fd;
            }else{ 
                var required_noti = ``;
                for (var i = 0; i < required_data.length; i++) { required_noti += `<div class="notification-item error">${required_data[i]}</div>`; }
                $(`${resource}`).find('.notification-wrapper').prepend(` <div class="notification-group">${required_noti}</div> `)
                return false;
            }
        }, 
        onPush(name, callback){
            $(document).on('click', `.send-invite`, function() {
                if($(this).attr('atr').trim() == name) {
                    var data = View.Invite.getVal(); 
                    if (data) callback(data);
                }
            });
        },
    },
    Task: {
        render(data){
            $(".task-list-item").find(".task-item").remove()
            data.map(v => {
                $(".task-list-item")
                    .append(`<div class="task-item" task-id=${v.id}>
                                <div class="task-done"><i class="fas fa-check-circle"></i></div>
                                <div class="task-name" modal-control="Task">${v.name}</div>
                            </div> `)
            })
        },
        GetOne(callback){
            $(document).on('click', `.task-list-item .task-item`, function() {
                var task_id = $(this).attr("task-id")
                callback(task_id);
            }); 
        },
        renderData(data){ 
            var resource = $("#modal-task");
            resource.attr("task-id", data.task.id)
            resource.find(".data-name").val(data.task.name)
            resource.find(".data-assign").val(data.task.customer_assign) 
            resource.find(".data-start").val(data.task.start_date)
            resource.find(".data-end").val(data.task.end_date)
            resource.find(".data-priority").val(data.task.priority)
            resource.find(".data-description").val(data.task.description == null ? "" : data.task.description.replace(/(<([^>]+)>)/ig, ""))
            View.Task.Assign.user.map(v => {
                if (v.customer_id == data.task.customer_assign) {
                    resource.find(".item-content").removeClass("no-assign");
                    resource.find(".user-wrapper .user-name").text(v.name);
                }
            })
        },
        getVal(){
            var resource = "#modal-task";
            var fd = new FormData();
            var required_data = [];
            var onPushData = true;

            var data_id             = $(`${resource}`).attr("task-id");
            var data_name           = $(`${resource}`).find('.data-name').val(); 
            var data_assign         = $(`${resource}`).find('.data-assign').val(); 
            var data_start          = $(`${resource}`).find('.data-start').val(); 
            var data_end            = $(`${resource}`).find('.data-end').val(); 
            var data_priority       = $(`${resource}`).find('.data-priority').val(); 
            var data_description    = $(`${resource}`).find('.data-description').val();  

            if (onPushData) {
                fd.append('data_id', data_id);  
                fd.append('data_name', data_name);  
                fd.append('data_assign', data_assign);  
                fd.append('data_start', data_start);  
                fd.append('data_end', data_end);  
                fd.append('data_priority', data_priority);  
                fd.append('data_description', data_description);  
                return fd;
            }else{ 
                var required_noti = ``;
                for (var i = 0; i < required_data.length; i++) { required_noti += `<div class="notification-item error">${required_data[i]}</div>`; }
                $(`${resource}`).find('.notification-wrapper').prepend(` <div class="notification-group">${required_noti}</div> `)
                return false;
            }
        },
        onSave(callback){
            $(document).on('click', `.dialog-footer .btn-save`, function() { 
                var data = View.Task.getVal();
                callback(data);
            }); 
        },
        SubTask: {
            Create(callback){
                $('.input-create-subtask').on('keypress', function (e) {
                    if(e.which === 13){ 
                        var data_name = $(this).val(); 
                        var fd = new FormData();
                        fd.append('task_id', $("#modal-task").attr("task-id"));   
                        fd.append('data_name', data_name);   
                        callback(fd);
                    }
               }); 
            },
            Update(callback){
                $(document).on('click', `.sub-task-item .sub-task-done`, function() {
                    var task_id = $(this).parent().attr("sub-task-id")
                    callback(task_id, $("#modal-task").attr("task-id"));
                }); 
            },
            Delete(callback){
                $(document).on('click', `.sub-task-item .sub-task-remove`, function() {
                    var task_id = $(this).parent().attr("sub-task-id")
                    callback(task_id, $("#modal-task").attr("task-id"));
                });
            },
            render(data){
                $(".sub-task-list .item-list .sub-task-item").remove();
                data.map(v => {
                    $(".sub-task-list .item-list")
                        .append(`<div class="sub-task-item" sub-task-id="${v.id}">
                                    <div class="sub-task-done ${v.status == 1 ? "task-done" : ""}"><i class="fas fa-check-circle"></i></div>
                                    <div class="sub-task-name">${v.description}</div>
                                    <div class="sub-task-remove"><i class="fas fa-times"></i></div>
                                </div> `)
                })
            }
        },
        Assign: {
            user: [],
            doCreate(callback){
                $('.create-content-task').on('keypress', function (e) {
                    if(e.which === 13){
                        var data_name = $(this).val(); 
                        var fd = new FormData();
                        fd.append('data_name', data_name);   
                        callback(fd);
                    }
               });
            },
            onAssign(callback){
                $(document).on('click', `.user-assign`, function() {
                    $(this).addClass("is-open-mail");
                    callback();
                });
            },
            doAssign(callback){
                $(document).on('click', `.user-team-item`, function() {
                    var user_id = $(this).attr("customer-id")
                    var user_name = $(this).attr("customer-name")
                    var father = $(this).parent().parent().parent();
                    father.removeClass("no-assign");
                    father.find(".user-wrapper .user-name").text(user_name)
                    callback(user_id);
                });
            },
            removeAssign(callback){
                $(document).on('click', `.user-action`, function() {
                    $(this).parent().parent().addClass("no-assign"); 
                    callback();
                });
            },
            renderAssign(data){
                $("#modal-task .user-list-team").find(`.user-team-item`).remove()

                $("#modal-task .user-list-team")
                    .append(`<div class="user-team-item" customer-id="${data.owner.customer_id}" customer-name="${data.owner.name}">
                                <div class="user-avatar"> </div>
                                <div class="user-name"> ${data.owner.name}</div>
                                <div class="user-email">${data.owner.email}</div>
                            </div>`)
                data.collab.map(v => {
                    $("#modal-task .user-list-team")
                        .append(`<div class="user-team-item" customer-id="${v.customer_id}" customer-name="${v.name}">
                                    <div class="user-avatar"> </div>
                                    <div class="user-name"> ${v.name}</div>
                                    <div class="user-email">${v.email}</div>
                                </div>`)
                })
            },
            init(){ 
                $(document).mouseup(function(e) {
                    var container = $(".user-assign");
                    if (!container.is(e.target) && container.has(e.target).length === 0) {
                        $(".user-assign").removeClass("is-open-mail");
                    }
                });
            }
        },
    },
    validateEmail(email){
        return email.match( /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ );
    },
    init(){
        View.Task.Assign.init();
    }
};
// Controller
(() => { 
    View.init();
    async function redirect_logined(url, delayValue) {
        await delay(delayValue);
        window.location.replace(url);
    }
    async function close_modal(delayValue) {
        await delay(delayValue);
        $('.I-modal').removeClass('active');
    }
    function delay(delayInms) {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve(2);
            }, delayInms);
        });
    }
    function init(){
        getCollab(); 
        getTask();
        GetAssign();
    }
    View.Invite.onPush("Push", (fd) => { 
        IndexView.Notification.remove(`#invite-form`); 
        $(".send-invite").text(`Inviting`)
        Api.Collab.Sending(fd)
            .done(res => {
                if (res.status == 200) {
                    $(".send-invite").text(`Logined`) 
                    IndexView.Notification.append(`#invite-form`, `success`, res.message); 
                    View.Invite.setDefaul();
                    close_modal(1000); 
                }else{
                    $(".send-invite").text(`Invite`) 
                    IndexView.Notification.append(`#invite-form`, `error`, res.message);  
                }
            })
            .fail(err => { })
            .always(() => { });
    })
    View.Task.Assign.onAssign(() => {
        GetAssign()
    })
    View.Task.Assign.doAssign((customer_id) => {
        // GetAssign()
        $(".data-assign").val(customer_id)
    })
    View.Task.Assign.removeAssign((customer_id) => {
        // GetAssign()
        $(".data-assign").val(0)
    })
    View.Task.Assign.doCreate((fd) => {
        Api.Task.Create(fd).done(res => {
                if (res.status == 200) {
                    $('.create-content-task').val("")
                    getTask();
                } 
        })
        .fail(err => { })
        .always(() => { });
    })
    View.Task.GetOne((id) => {
        Api.Task.GetOne(id).done(res => {
            View.Task.renderData(res.data); 
            View.Task.SubTask.render(res.data.sub_task)
        })
        .fail(err => { })
        .always(() => { });
    })

    View.Task.SubTask.Create((fd) => {
        Api.SubTask.Create(fd).done(res => {
            if (res.status == 200) {
                $('.input-create-subtask').val("")
                View.Task.SubTask.render(res.data)
            } 
        })
        .fail(err => { })
        .always(() => { });
    })
    View.Task.SubTask.Update((id, task_id) => { 
        Api.SubTask.Update(id, task_id).done(res => {
            if (res.status == 200) { 
                View.Task.SubTask.render(res.data)
            } 
        })
        .fail(err => { })
        .always(() => { });
    })
    View.Task.SubTask.Delete((id, task_id) => { 
        Api.SubTask.Delete(id, task_id).done(res => {
            if (res.status == 200) { 
                View.Task.SubTask.render(res.data)
            } 
        })
        .fail(err => { })
        .always(() => { });
    })
    View.Task.onSave((fd) => {
        Api.Task.Update(fd).done(res => {
                if (res.status == 200) {
                    $('.I-modal').removeClass('active');
                    getTask();
                } 
        })
        .fail(err => { })
        .always(() => { });
    })

    function getCollab(){
        Api.Collab.GetAll()
            .done(res => {
                View.Invite.render(res.data); 
            })
            .fail(err => {  })
            .always(() => { });
    }
    function getTask(){
        Api.Task.GetAll()
            .done(res => {
                View.Task.render(res.data);  
            })
            .fail(err => {  })
            .always(() => { });
    }
    function GetAssign(){
        Api.Collab.GetAssign()
            .done(res => { 
                View.Task.Assign.renderAssign(res.data);
                View.Task.Assign.user.push(res.data.owner);
                res.data.collab.map(v => {
                    View.Task.Assign.user.push(v);
                })
            })
            .fail(err => {  })
            .always(() => { });
    }
    init();
})();