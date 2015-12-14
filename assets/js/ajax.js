

    jQuery(document).ready(function($) {

        // register


            $('#uc-register').on('click',function(e){


                        e.preventDefault();
                        var get_all_data = $('#uc-register-form').serializeArray();

                        $.ajax({
                                    url: ajax_object.ajaxurl+'?action=uc_register',
                                    type: 'POST',
                                    dataType:"json",
                                    data: get_all_data,
                                    success:function(result){
                                                $("span.error").remove();
                                                $("div.success").html("");
                                                for(i in result){

                                                            if(result[i].name !== undefined){
                                                                        $("input[name='agency_name']").after("<span class='error'>"+result[i].name +"</span>");
                                                            }

                                                            if(result[i].email !== undefined){
                                                                        $("input[name='email']").after("<span class='error'>"+result[i].email +"</span>");
                                                            }

                                                            if(result[i].password !== undefined){
                                                                        $("input[name='password']").after("<span class='error'>"+result[i].password +"</span>");
                                                            }

                                                            if(result[i].username !== undefined){
                                                                        $("input[name='username']").after("<span class='error'>"+result[i].username +"</span>");
                                                            }

                                                            if(result[i].msg !== undefined){
                                                                        $("div.success").html(result[i].msg);
                                                                        window.location.href = result[i].url;
                                                            }

                                                }

                                    }
                        });

            });


            $('#uc-company').on('click',function(e){


                        e.preventDefault();
                        var get_all_data = $('#uc-company-form').serializeArray();

                        $.ajax({
                                    url: ajax_object.ajaxurl+'?action=uc_company',
                                    type: 'POST',
                                    dataType:"json",
                                    data: get_all_data,
                                    success:function(result){
                                                $("span.error").remove();
                                                $("div.success").html("");
                                                for(i in result){

                                                            if(result[i].name !== undefined){
                                                                        $("input[name='company_name']").after("<span class='error'>"+result[i].name +"</span>");
                                                            }

                                                            if(result[i].email !== undefined){
                                                                        $("input[name='email']").after("<span class='error'>"+result[i].email +"</span>");
                                                            }

                                                            if(result[i].password !== undefined){
                                                                        $("input[name='password']").after("<span class='error'>"+result[i].password +"</span>");
                                                            }

                                                            if(result[i].username !== undefined){
                                                                        $("input[name='username']").after("<span class='error'>"+result[i].username +"</span>");
                                                            }

                                                            if(result[i].msg !== undefined){
                                                                        $("div.success").html(result[i].msg);
                                                                        
                                                            }

                                                }

                                    }
                        });

            });

            $('#uc-candidate-register').on('click',function(e){


                        e.preventDefault();
                        var get_all_data = $('#uc-candidate-register-form').serializeArray();

                        $.ajax({
                                    url: ajax_object.ajaxurl+'?action=uc_candidate',
                                    type: 'POST',
                                    dataType:"json",
                                    data: get_all_data,
                                    success:function(result){
                                                $("span.error").remove();
                                                $("div.success").html("");
                                                for(i in result){

                                                            
                                                            if(result[i].email !== undefined){
                                                                        $("input[name='email']").after("<span class='error'>"+result[i].email +"</span>");
                                                            }

                                                            if(result[i].password !== undefined){
                                                                        $("input[name='password']").after("<span class='error'>"+result[i].password +"</span>");
                                                            }

                                                            if(result[i].username !== undefined){
                                                                        $("input[name='username']").after("<span class='error'>"+result[i].username +"</span>");
                                                            }

                                                            if(result[i].msg !== undefined){
                                                                        $("div.success").html(result[i].msg);
                                                                        
                                                            }

                                                }

                                    }
                        });

            });


        // for edit profile

        $('#agency-profile-edit-submit').on('click',function(e){
            e.preventDefault();
            tinyMCE.triggerSave();
            var get_all_data = $('#agency-edit').serializeArray();

            $.ajax({
                url: ajax_object.ajaxurl+'?action=uc_agency_edit',
                type: 'POST',
                dataType:"json",
                data: get_all_data,
                success:function(r){

                    // need to show success message
                   if(r.success) $('.success').html(r.success);
                   if(r.error) $('.error').html(r.error);
                }

            });
        });



        // for create agent


        $('#create_agent_submit').on('click',function(e){
            e.preventDefault();
            var get_all_data = $('#create_agent').serializeArray();

            $.ajax({
                url: ajax_object.ajaxurl+'?action=uc_create_agent',
                type: 'POST',
                dataType:"json",
                data: get_all_data,
                success:function(r){
                    // need to show success message
                  //  if(r.success) $('.success').html(r.success);
                  //  if(r.error) $('.error').html(r.error);
                    console.log(r);
                }

            });
        });

             $('#create_hr_submit').on('click',function(e){
                e.preventDefault();
                var get_all_data = $('#create_hr').serializeArray();

                $.ajax({
                    url: ajax_object.ajaxurl+'?action=uc_create_hr',
                    type: 'POST',
                    dataType:"json",
                    data: get_all_data,
                    success:function(r){
                        // need to show success message
                      //  if(r.success) $('.success').html(r.success);
                      //  if(r.error) $('.error').html(r.error);
                        console.log(r);
                    }

                });
            });

             $('#create_job_submit').on('click',function(e){
                        e.preventDefault();
                        tinyMCE.triggerSave();
                        var get_all_data = $('#create_job').serializeArray();

                        $.ajax({
                            url: ajax_object.ajaxurl+'?action=uc_create_job',
                            type: 'POST',
                            dataType:"json",
                            data: get_all_data,
                            success:function(r){
                                // need to show success message
                              //  if(r.success) $('.success').html(r.success);
                              //  if(r.error) $('.error').html(r.error);
                                console.log(r);
                            }

                        });
            });


        // login
        $('#uc-login').on('click',function(e){


                        e.preventDefault();
                        var get_all_data = $('#uc-login-form').serializeArray();

                        $.ajax({
                                    url: ajax_object.ajaxurl+'?action=uc_login',
                                    type: 'POST',
                                    dataType:"json",
                                    data: get_all_data,
                                    success:function(result){
                                               if(!result.loggedin){
                                                      $(".status").html(result.message)
                                               }else{
                                                      $(".status").html(result.message);
                                                      window.location.href = result.url;
                                               }

                                    }
                        });

            });
            $(".hire-btn").on('click', function(e){
                        e.preventDefault();
                        var get_all_data = $(this).parent().serializeArray();

                        $.ajax({
                                    url: ajax_object.ajaxurl+'?action=uc_agency_hire',
                                    type: 'POST',
                                    dataType:"json",
                                    data: get_all_data,
                                    success:function(result){
                                               if(!result.loggedin){
                                                      $(".status").html(result.message)
                                               }else{
                                                      $(".status").html(result.message);
                                                      window.location.href = result.url;
                                               }

                                    }
                        });
            });




        // assign company to agent

        $('button.assign-com').on('click',function(e){

            e.preventDefault();

            var agent_id = $(this).attr('data-agent-id');
            var agency_id = $(this).attr('data-agency-id');
            var agency_admin_id = $(this).attr('data-agency-admin');


            $.ajax({
                url : ajax_object.ajaxurl+'?action=uc_agent_not_assigned_company',
                type: 'POST',
                dataType:"json",
                data:'agent_id='+agent_id+'&agency_id='+agency_id+'&agency_admin_id='+agency_admin_id,
                success: function(result){
//                    var template = $('#template').html();
//                    Mustache.parse(template);
//                    var rendered = Mustache.render( template, result );
//                    $('.target').html(rendered);


                    var tableTemplate = $("#table-data").html();

                    $(".target").html(_.template( tableTemplate, result ));

                    do_attach( agent_id ,agency_id );


                }
            });

        });


    function do_attach( agent_id , agency_id ){
        $('button.attach-with-company').on('click',function(e){
            e.preventDefault();

            var but = $(this);

            var company_id = but.attr('data-company-id');

            $.ajax({
                url : ajax_object.ajaxurl+'?action=uc_assign_agent',
                type: 'POST',
                dataType:"json",
                data:'agent_id='+agent_id+'&agency_id='+agency_id+'&company_id='+company_id,
                success:function(c){
                    if(c.error == 0 )
                        but.hide();
                }
            });

        });

    }


});