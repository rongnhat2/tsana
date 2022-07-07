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
        onChangeTab(callback){ 
            $(document).on('click', `.tab-control-wrapper .tab-control-item`, function() { 
                $(".tab-control-wrapper .tab-control-item").removeClass("is-active");
                $(this).addClass("is-active")
                callback($(this).attr("tab-id"));
            }); 
        },
        render(data){
            $(".task-list-item").find(".task-item").remove()
            data.map(v => {
                $(".task-list-item")
                    .append(`<div class="task-item" task-id=${v.id}>
                                <div class="task-done ${v.status == 1 ? "is-done" : "task-comming"}"><i class="fas fa-check-circle"></i></div>
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
            resource.find(".data-project").val(data.task.project_id) 
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
            $(".project-list-wrapper .project-item").remove();
            View.Task.AssignProject.project.map(v => {
                $(".project-list-wrapper").append(`<div class="project-item" project-id="${v.id}" project-name="${v.name}">${v.name}</div>`) 
            })
            if (!data.task.project_id) {
                $(".project-assign").addClass("on-show");
                $(".project-select-wrapper").removeClass("on-show");
            }else{
                $(".project-select-wrapper").addClass("on-show");
                $(".project-assign").removeClass("on-show");
                View.Task.AssignProject.project.map(v => {
                    if(v.id == data.task.project_id) $(".project-select-wrapper .project-name").text(v.name);
                })
            }
        },
        getVal(){
            var resource = "#modal-task";
            var fd = new FormData();
            var required_data = [];
            var onPushData = true;

            var data_id             = $(`${resource}`).attr("task-id");
            var data_name           = $(`${resource}`).find('.data-name').val(); 
            var data_assign         = $(`${resource}`).find('.data-assign').val(); 
            var data_project        = $(`${resource}`).find('.data-project').val(); 
            var data_start          = $(`${resource}`).find('.data-start').val(); 
            var data_end            = $(`${resource}`).find('.data-end').val(); 
            var data_priority       = $(`${resource}`).find('.data-priority').val(); 
            var data_description    = $(`${resource}`).find('.data-description').val();  

            if (onPushData) {
                fd.append('data_id', data_id);  
                fd.append('data_name', data_name);  
                fd.append('data_assign', data_assign);
                fd.append('data_project', data_project);  
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
        onDone(callback){
            $(document).on('click', `.task-item .task-comming`, function() { 
                var task_id = $(this).parent().attr("task-id");
                callback(task_id);
            }); 
            $(document).on('click', `.mark-done-wrapper`, function() { 
                var task_id = $("#modal-task").attr("task-id");
                callback(task_id);
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
        AssignProject: {
            project: [],
            onAssign(callback){
                $(document).on('click', `.project-assign`, function() {
                    $(this).addClass("do-select");
                    callback();
                });
            },
            doAssign(callback){
                $(document).on('click', `.project-item`, function() {
                    var project_id = $(this).attr("project-id") 
                    var project_name = $(this).attr("project-name") 
                    var father = $(this).parent().parent().parent();
                    father.find(".project-assign").removeClass("on-show");
                    father.find(".project-assign").removeClass("do-select");
                    father.find(".project-select-wrapper").addClass("on-show");
                    father.find(".project-select-wrapper .project-name").text(project_name)
                    callback(project_id);
                });
            },
            removeAssign(callback){
                $(document).on('click', `.project-action`, function() {
                    var father = $(this).parent().parent();
                    father.find(".project-assign").addClass("on-show");
                    father.find(".project-assign").addClass("do-select");
                    father.find(".project-select-wrapper").removeClass("on-show");
                    callback();
                });
            },
            init(){ 
                $(document).mouseup(function(e) {
                    var container = $(".project-assign");
                    if (!container.is(e.target) && container.has(e.target).length === 0) {
                        $(".project-assign").removeClass("do-select");
                    }
                });
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
    Project: {
        render(data){
            $(".project-main-wrapper .project-list .project-item").remove();
            $(".project-list-group .project-item-block").remove();
            data.map(v => {
                var project_value = `<div class="project-item ${v.privacy == 0 ? "project-public" : "project-private"}">
                                        <div class="project-icon"></div>
                                        <div class="project-name">
                                            ${v.name}
                                        </div> 
                                        <div class="project-action"> 
                                            ${v.privacy == 0 ? "" : `<i class="fas fa-lock"></i>`}
                                        </div>
                                    </div> `
                $(".project-main-wrapper .project-list")
                    .append(project_value);

                $(".project-list-group")
                    .append(` <div class="project-item project-item-block">
                                    <div class="project-icon">
                                        
                                    </div>
                                    <div class="project-description">
                                        <div class="project-name">${v.name}</div>
                                        <div class="project-task">${v.total_task} task</div>
                                    </div>
                                </div> `)
            })
        },
        onChangeSprint(){
            var resource = "#modal-project"; 
            $(document).on('click', `${resource} .sprint-item`, function() { 
                $(".sprint-item").removeClass("is-selected");
                $(this).addClass("is-selected");
            }); 
        },
        getVal(){
            var resource = "#modal-project";
            var fd = new FormData();
            var required_data = [];
            var onPushData = true;
 
            var data_name          = $(`${resource}`).find('.data-name').val(); 
            var data_privacy       = $(`${resource}`).find('.data-privacy').val();  
            var data_type          = $(`${resource}`).find(`.sprint-item.is-selected`).attr("sprint-type");  

            if (data_name == '') {  required_data.push('Name is required.'); onPushData = false  }

            if (onPushData) {
                fd.append('data_privacy', data_privacy);  
                fd.append('data_name', data_name);  
                fd.append('data_type', data_type);   
                return fd;
            }else{ 
                var required_noti = ``;
                for (var i = 0; i < required_data.length; i++) { required_noti += `<div class="notification-item error">${required_data[i]}</div>`; }
                $(`${resource}`).find('.notification-wrapper').prepend(` <div class="notification-group">${required_noti}</div> `)
                return false;
            }
        },
        onCreate(callback){
            var resource = "#modal-project";
            $(document).on('click', `${resource} .project-create`, function() { 
                var data = View.Project.getVal();
                callback(data);
            }); 
        },
        init(){
            this.onChangeSprint()
        }
    },
    validateEmail(email){
        return email.match( /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ );
    },
    init(){
        View.Task.Assign.init();
        View.Task.AssignProject.init();
        View.Project.init();
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
        getTask(0);
        GetAssign();
        getProject();
    }
    
    // const xhrSaleChannel = Api.SaleChannel.ReadAll();
    // const xhrStore = Api.Store.ReadAll();

    // $.when(xhrSaleChannel, xhrStore).done((...responses) => {
    //     resSaleChannel = xhrSaleChannel.responseJSON;
    //     resStore = xhrStore.responseJSON;
    //     View.filters.multistore.__storeArray = resStore.data;
    //     View.filters.multistore.init();

    //     View.filters.fetch({
    //         saleChannels: resSaleChannel.data,
    //         stores: resStore.data
            
    //     });
    //     setURLDefaul();
    //     getURLData();
    // });

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
                    getProject();
                } 
        })
        .fail(err => { })
        .always(() => { });
    })
    View.Task.onDone((id) => {
        Api.Task.onDone(id)
            .done(res => {
                getTask(0);
                $('.I-modal').removeClass('active');
        })
        .fail(err => { })
        .always(() => { });
    })
    View.Task.onChangeTab((id) => {
        getTask(id);
    })

    View.Task.AssignProject.onAssign(() => {
        // GetAssign()
    })
    View.Task.AssignProject.doAssign((id) => { 
        $(".data-project").val(id) 
    })
    View.Task.AssignProject.removeAssign(() => { 
        $(".data-project").val(0)
    })


    View.Project.onCreate((fd) => { 
        Api.Project.Create(fd)
            .done(res => {
                if (res.status == 200) {
                    getProject()
                    $('.I-full-modal').removeClass('active');
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
    function getTask(id){
        Api.Task.GetAll(id)
            .done(res => {
                View.Task.render(res.data);  
            })
            .fail(err => {  })
            .always(() => { });
    }
    function getProject(){
        Api.Project.GetAll()
            .done(res => {
                View.Project.render(res.data);
                View.Task.AssignProject.project = res.data;
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