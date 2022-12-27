


function makeSearchable() {
    let newDataTable = `dataTable_${Math.floor(Math.random() * 9999999999999999)}`
    // alert(newDataTable)
    // randomi indexing the id attribute to prevent reinitialiindexation error from jquery datatable

    $('.dataTable').attr('id', newDataTable)
    // any table with the class dataTable must have and id and each time the button
    // is clicked,new id is assigned to the table with the dataTable class
    $(`#${newDataTable}`).dataTable({
        // new initialiindexation each time the button is clicked
        stateSave: true,
        paging: false,
        retrieve: true

    });
}


$(document).ready(() => {


    $("#current_password").keyup(() => {
        let current_pwd = $("#current_password").val();
        $.ajax({
            type: 'post',
            url: '/admin/check-current-password',
            data: { current_pwd },
            success: (res) => {
                if (res == 'false') {
                    $('#checkPassWd').html("<font color='red'>Oops Current Password Is Incorrect!</font> ")
                } else if (res == 'true') {
                    $('#checkPassWd').html("<font color='green'>Password Matched Old Password!</font> ")

                } else {
                    $('#checkPassWd').html("<font color='red'>Oops Current Password Is Incorrect!</font> ")

                }
            }, error: (request, status, error) => {
                alert('err' + request.responseText)
            }
        })

    })

    // get vendor's info with fetch
    $(".get-vendor-det").click(async () => {
        let section_id = $(".section_id").val();
        let adminDetails = await fetch(`/admin/view-vendor-details/${section_id}`)
        adminDetails = await adminDetails.json()
        vendorName = adminDetails.get_vendor_details_from_admin.name
        // vendor business info
        $('.bus-intro').text(`Business Details Of ${vendorName}`)
        $('#shop_address').val(adminDetails.get_vendor_business_details_from_admin.shop_address)
        $('#shop_mobile').val(adminDetails.get_vendor_business_details_from_admin.shop_mobile)
        $('#shop_name').val(adminDetails.get_vendor_business_details_from_admin.shop_name)
        $('#shop_city').val(adminDetails.get_vendor_business_details_from_admin.shop_city)
        $('#shop_state').val(adminDetails.get_vendor_business_details_from_admin.shop_state)
        $('#shop_country').val(adminDetails.get_vendor_business_details_from_admin.shop_country)
        $('#shop_email').val(adminDetails.get_vendor_business_details_from_admin.shop_email)
        $('#shop_license_number').val(adminDetails.get_vendor_business_details_from_admin.shop_license_number)
        $('#shop_website').val(adminDetails.get_vendor_business_details_from_admin.shop_website)
        $('#shop_address_proof').val(adminDetails.get_vendor_business_details_from_admin.shop_address_proof)
        vendor_proof_img = adminDetails.get_vendor_business_details_from_admin.shop_address_proof_image
        domain_name = window.location.hostname
        // remember to remove this :9000 when deploying the app
        $('.vendor_proof_img').attr("src", `/admin/images/vendor_address_proofs/${vendor_proof_img}`)
        // end of vendor business info
        // start of vendor business info
        $('.pers-intro').text(`Personal Details Of ${vendorName}`)
        $('#name').val(adminDetails.get_vendor_details_from_admin.name)
        $('#address').val(adminDetails.get_vendor_details_from_admin.address)
        $('#digital_address').val(adminDetails.get_vendor_details_from_admin.digital_address)
        $('#city').val(adminDetails.get_vendor_details_from_admin.city)
        $('#state').val(adminDetails.get_vendor_details_from_admin.state)
        $('#country').val(adminDetails.get_vendor_details_from_admin.country)
        $('#mobile').val(adminDetails.get_vendor_details_from_admin.mobile)
        $('#email').val(adminDetails.get_vendor_details_from_admin.email)
        vendor_img = adminDetails.image
        $('.vendor_img').attr("src", `/admin/images/dynamic_images/${vendor_img}`)
        // end of vendor business info
        // start of vendor bank info
        $('.bank-intro').text(`Bank Details Of ${vendorName}`)

        $('#account_holder_name').val(adminDetails.get_vendor_bank_details_from_admin.account_holder_name)
        $('#bank_name').val(adminDetails.get_vendor_bank_details_from_admin.bank_name)
        $('#account_number').val(adminDetails.get_vendor_bank_details_from_admin.account_number)








    })

    // toggle admin/vendor status
    $(document).on('click', '.status_changer', async function () {
        current_id_from_td = $(this).children('i').attr('id')

        sectionId = $(`#${current_id_from_td}`).attr("section_id")
        currentAdminStatus = $(`#${current_id_from_td}`).attr(`section_status_${sectionId}`)

        let res = await fetch(`/admin/change-admin-status/${sectionId}/${currentAdminStatus}`)
        res = await res.json()
        console.log(res)
        if (res.updated_status == 0) {
            //admin/vendor not approved
            $(`#${current_id_from_td}`).attr("class", "mdi mdi-toggle-switch-off");
            $(`.section_status_${sectionId}`).attr('class', `section_status_${sectionId} mdi mdi-checkbox-multiple-blank-circle-outline text-dark`)
            $(`#${current_id_from_td}`).attr(`section_status_${sectionId}`, 0)

            $(`.section_status_${sectionId}`).text('Inactive')

        } else if (res.updated_status == 1) {
            //admin/vendor approved
            $(`#${current_id_from_td}`).attr("class", "mdi mdi-toggle-switch text-primary");
            $(`.section_status_${sectionId}`).text('Active')
            $(`.section_status_${sectionId}`).attr('class', `section_status_${sectionId} mdi mdi-checkbox-multiple-blank-circle text-success`)
            $(`#${current_id_from_td}`).attr(`section_status_${sectionId}`, 1)

        }

    })

    // toggle productsection status
    $(document).on('click', '.status_changer_2', async function () {
        current_id_from_td = $(this).children('i').attr('id')

        sectionId = $(`#${current_id_from_td}`).attr("section_id")
        currentAdminStatus = $(`#${current_id_from_td}`).attr(`section_status_${sectionId}`)
        // get current id and status

        let res = await fetch(`/admin/change-section-status/${sectionId}/${currentAdminStatus}`)
        //    pass it to fetch
        res = await res.json()
        // get res.json
        if (res.updated_status == 0) {
            //admin/vendor not approved
            $(`#${current_id_from_td}`).attr("class", "mdi mdi-toggle-switch-off");
            $(`.section_status_${sectionId}`).attr('class', `section_status_${sectionId} mdi mdi-checkbox-multiple-blank-circle-outline text-dark`)
            $(`#${current_id_from_td}`).attr(`section_status_${sectionId}`, 0)

            $(`.section_status_${sectionId}`).text('Inactive')

        } else if (res.updated_status == 1) {

            //admin/vendor approved
            $(`#${current_id_from_td}`).attr("class", "mdi mdi-toggle-switch text-primary");
            $(`.section_status_${sectionId}`).text('Active')
            $(`.section_status_${sectionId}`).attr('class', `section_status_${sectionId} mdi mdi-checkbox-multiple-blank-circle text-success`)
            $(`#${current_id_from_td}`).attr(`section_status_${sectionId}`, 1)

        }

    })



    // validate section-name
    $('.sect-name').keyup(async () => {
        res = await Request.post('admin/update-section', $('.sect-name').val())
        res = await res.json()
        alert(res)

    })


    // listen to show-add-section-modal event(from-livewire)
    window.addEventListener('show-add-section-modal', e => {
        $('#add-section-modal').modal('show');

    });


    // listen to show-produt-attr-modal event(from-livewire)
    window.addEventListener('show-produt-attr-modal', e => {
        $('#produt-attr-modal').modal('show');

    });


    // listen to show-add-brand-modal event(from-livewire)
    window.addEventListener('show-add-brand-modal', e => {
        $('#add-brand-modal').modal('show');

    });

    window.addEventListener('show-add-product-modal', e => {
        $('#add-product-modal').modal('show');

    });

    // listen to show-add-category-modal event(from-livewire)
    window.addEventListener('show-add-category-modal', e => {
        $('#add-category-modal').modal('show');

    });



    // listen to hide-add-section-modal event(from-livewire)
    window.addEventListener('hide-add-section-modal', e => {
        $('#add-section-modal').modal('hide');
        if (!e.detail.is_cancel) {
            // success message will only show if is_cancel is not specified
            // for this event
            toastr.success(e.detail.success_msg, 'Success')
        }

    });

    // a function for clearing any input field with just id
    // it must have the id #img_file for it to work
    window.addEventListener('clear-fieild', e => {
        let imgFile = $('#img_file').val('').clone(true);

    })



    //     window.addEventListener('hide-add-employee-modal',e=>{
    //         $('#add-employee-modal').modal('hide');


    //     Swal.fire({
    //         title: 'EMPLOYEE RECORD SAVED',
    //         text: e.detail.success_msg,
    //         icon: 'success',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#00000',
    //         // confirmButtonText: 'Yes, delete it!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //         //    if user clicks ok,they are redirected to the dashboard
    //         $('#add-employee-modal').modal('hide');


    //         }
    //     })
    // })
    // listen to hide-add-product-modal event(from-livewire)
    window.addEventListener('hide-add-product-modal', e => {
        $('#add-product-modal').modal('hide');
        let vidfile = $('#prd_vid_file').val('').clone(true);
        let imgfile = $('#prd_img_file').val('').clone(true);

        if (!e.detail.is_cancel) {
            // success message will only show if is_cancel is not specified
            // for this event
            toastr.success(e.detail.success_msg, 'Success')
        }

    });
    // listen to hide-add-brand-modal event(from-livewire)
    window.addEventListener('hide-add-brand-modal', e => {
        $('#add-brand-modal').modal('hide');
        // alert(e.detail.is_cancel)
        if (!e.detail.is_cancel) {
            // success message will only show if is_cancel is not specified
            // for this event
            toastr.success(e.detail.success_msg, 'Success')
        }

    });
    window.addEventListener('show-success-toast', e => {

        // just for success messages
        toastr.success(e.detail.success_msg, 'Success')

    });

    window.addEventListener('show-error-toast', e => {

        // just for success messages
        toastr.error(e.detail.error_msg, 'Error')


    });

    window.addEventListener('hide-produt-attr-modal', e => {
        $('#produt-attr-modal').modal('hide');

        toastr.success(e.detail.success_msg, 'Success')


    });

    window.addEventListener('clear-file-fields', e => {
        let imagefile = $('#prd_img_file').val('').clone(true);
        let vidfile = $('#prd_vid_file').val('').clone(true);


    })

    // listen to hide-add-category-modal event(from-livewire)
    window.addEventListener('hide-add-category-modal', e => {
        $('#add-category-modal').modal('hide');

        // laravel keeps old state of file name,which needs to be cleared
        let imagefile = $('#cat_img_file').val('').clone(true);
        if (!e.detail.is_cancel) {
            // success message will only show if is_cancel is not specified
            // for this event
            toastr.success(e.detail.success_msg, 'Success')
        }

    });







    window.addEventListener(('emp_rec_err'), e => {
        $('#add-employee-modal').modal('hide');
        toastr.error(e.detail.msg, 'Error')




    });
    // handle all delete events from livewire
    let deleteEvents = [{ eventFromLiveWire: 'show_category_del_confirm', eventToLiveWire: 'confirm_category_delete' }, { eventFromLiveWire: 'delete_only_vid', eventToLiveWire: 'confirm_delete_only_vid' }
        , { eventFromLiveWire: 'show_section_del_confirm', eventToLiveWire: 'confirm_section_delete' }, { eventFromLiveWire: 'show_category_del_all_confirm', eventToLiveWire: 'confirm_category_delete_all' }, { eventFromLiveWire: 'show_main_category_del_all_confirm', eventToLiveWire: 'confirm_main_category_delete_all' }, { eventFromLiveWire: 'show_section_del_confirm', eventToLiveWire: 'confirm_section_del_all' }, { eventFromLiveWire: 'show_emp_del_confirm', eventToLiveWire: 'confirm_emp_del' }, { eventFromLiveWire: 'show_admin_del_confirm', eventToLiveWire: 'confirm_admin_del' }, { eventFromLiveWire: 'show_product_del_confirm', eventToLiveWire: 'confirm_product_delete' }, { eventFromLiveWire: 'show_product_del_all_confirm', eventToLiveWire: 'confirm_product_delete_all' },
    { eventFromLiveWire: 'show_sup_del_confirm', eventToLiveWire: 'confirm_sup_del' },
    { eventFromLiveWire: 'show_cust_del_confirm', eventToLiveWire: 'confirm_cust_del' },
    { eventFromLiveWire: 'show_expense_del_confirm', eventToLiveWire: 'confirm_expense_del' }
    ]





    let openModalEvents = [{ eventFromLivewire: 'show-add-Expense-modal', selector: 'add-Expense-modal' },{ eventFromLivewire: 'show-add-salary-modal', selector: 'add-salary-modal' },{ eventFromLivewire: 'show-add-admin-modal', selector: 'add-admin-modal' }, { eventFromLivewire: 'show-add-employee-modal', selector: 'add-employee-modal' }, { eventFromLivewire: 'show-add-supplier-modal', selector: 'add-supplier-modal' }, , { eventFromLivewire: 'show-add-customer-modal', selector: 'add-customer-modal' }, { eventFromLivewire: 'show-view-order-modal', selector: 'view-order-modal' }]
    let closeModalEvents = [{ eventFromLivewire: 'hide-add-Expense-modal', selector: 'add-Expense-modal' },,{ eventFromLivewire: 'hide-add-salary-modal', selector: 'add-salary-modal' },,{ eventFromLivewire: 'hide-add-admin-modal', selector: 'add-admin-modal' }, { eventFromLivewire: 'hide-add-employee-modal', selector: 'add-employee-modal' }, { eventFromLivewire: 'hide-add-supplier-modal', selector: 'add-supplier-modal' }, , { eventFromLivewire: 'hide-add-customer-modal', selector: 'add-customer-modal' }]

    deleteEvents.forEach((event_) => {
        window.addEventListener(event_.eventFromLiveWire, e => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // telling livewire user has clicked on confimation to delete
                    Livewire.emit(event_.eventToLiveWire)

                }
            })
        });

    })
    openModalEvents.forEach((event_) => {
        window.addEventListener(event_.eventFromLivewire, e => {
            $(`#${event_.selector}`).modal('show');

        })
    })
    // Handle Dynamic Routing with livewire


    //   Livewire.on('click', '#next-page-link', () => {
    //     alert('erty')
    // window.history.pushState({}, '', '/next-page');
    // window.dispatchEvent(new PopStateEvent('popstate'));
    // });
    //   routes.forEach((route)=>{
    //   Livewire.on('click', '#dashboard', () => {
    //     window.history.pushState({}, '', '/here');
    //     window.dispatchEvent(new PopStateEvent('popstate'));
    //   alert('hiya')
    //   });
    //   })

    closeModalEvents.forEach((event_) => {
        window.addEventListener(event_.eventFromLivewire, e => {
            if (e.detail.success_msg) {
                toastr.success(e.detail.success_msg, 'Sucess!')
            } else if (e.detail.error_msg) {
                toastr.error(e.detail.error_msg, 'Sucess!')
            }


            $(`#${event_.selector}`).modal('hide');

        })
    })


    window.addEventListener('success-dashboard-redirect', e => {

        // alert('yh');
        Swal.fire({
            title: 'RECORD SAVED',
            text: e.detail.success_msg,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#00000',
            // confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                //    if user clicks ok,they are redirected to the dashboard
                window.location.href = '/admin/dashboard'

            }
        })


    })
    window.addEventListener('success-orders-redirect', e => {

        // alert('yh');
        Swal.fire({
            title: 'ORDER SUCCESS!',

            text: e.detail.success_msg,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#00000',
            confirmButtonText: "Lemi Glance My Orders!"
            // confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                //    if user clicks ok,they are redirected to the dashboard
                window.location.href = '/admin/orders'

            }
        })


    })
    window.addEventListener('success-dashboard', e => {

        // alert('yh');
        Swal.fire({
            title: 'RECORD SAVED',
            text: e.detail.success_msg,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#00000',
            // confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                //    if user clicks ok,they are redirected to the dashboard

            }
        })


    })
    // video validation
    window.addEventListener('show_file_err', e => {
        Swal.fire({
            title: 'File Upload Error',
            text: "We only accept video files for the Product's Cover Video(mp4,mov or mkv ONLY!)",
            icon: 'danger',
            // showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            // confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // telling livewire user has clicked on confimation to delete
                //  we will do nothing after confirmation,if user confirms,he/she rectifies
                // their mistake

            }
        })
    });

    window.addEventListener('delete_comfirmation', e => {
        Swal.fire(
            'Deleted!',
            e.detail.success_msg,
            'success'
        )

    })
    window.addEventListener('section_status_update', e => {
        toastr.success(e.detail.success_msg, 'Success')
    })
    window.addEventListener('category_status_update', e => {
        toastr.success(e.detail.success_msg, 'Success')
    })
    window.addEventListener('product_status_update', e => {
        toastr.success(e.detail.success_msg, 'Success')
    })




    window.addEventListener('set_old_image', (e) => {
        alert("e.detail.old_img_path")

    })


    // toastr-config
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }


    // select2 instances


    // $('#customers').select2();
    // $('#customers').on('change', function (e) {
    //     var data = $('#customers').select2("val");
    // @this.set('selected', data)
    // })



});




