$(() => {
    const insertId = new Array();

    const sendAjaxRequest = (formData, callback) => {
        jQuery.ajax({
            url: './verify.php',
            type: 'POST',
            dataType: 'JSON',
            data: formData,
            success: (data) => {
                callback(data);
            },
            error: (error) => {
                console.log(error);
            }
        });
    }

    const updateData = (data) => {
        if (data.status && data.query && 'updated' === data.query) {
            const updatedEntry = data.updated_data;
            const replaceWith = jQuery(`.user-data-body div button.form-visibility[data-id="${updatedEntry.id}"]`).closest('div');
            const serialNo = replaceWith.find('.s-no').text();
            html = `<div>
                <p>${serialNo}</p>
                <p>${updatedEntry.username}</p>
                <p>${updatedEntry.email}</p>
                <p>${updatedEntry.phone_no}</p>
                <p>${updatedEntry.dob}</p>
                <p>${updatedEntry.gender}</p>
                <p>${updatedEntry.hobbies}</p>
                <p>${updatedEntry.course}</p>
                <button class="form-visibility update-user-data" data-id="${updatedEntry.id}" data-form-heading="Update Entry" data-type="update">Update</button>
                <button class="delete-user-data" data-id="${updatedEntry.id}">Delete</button>
            </div>`;
            replaceWith.replaceWith(html);
        } else if (data.status) {
            const entry = data.entry;
            const userBody = jQuery('.user-data .user-data-body');
            const previousIndex = userBody.find('div').length + 1;
            entry.forEach((data, index) => {
                let html = '';
                if (insertId.includes(data.id)) {
                } else {
                    html = `<div>
                        <p class="s-no">${previousIndex + index}</p>
                        <p>${data.username}</p>
                        <p>${data.email}</p>
                        <p>${data.phone_no}</p>
                        <p>${data.dob}</p>
                        <p>${data.gender}</p>
                        <p>${data.hobbies}</p>
                        <p>${data.course}</p>
                        <button class="form-visibility update-user-data" data-id="${data.id}" data-form-heading="Update Entry" data-type="update">Update</button>
                        <button class="delete-user-data" data-id="${data.id}">Delete</button>
                    </div>`;
                    userBody.append(html);
                }
            })
        }
    }

    const getUserData = () => {
        let formData = {};
        formData.fetchUserData = true;
        sendAjaxRequest(formData, updateData);
    }
    getUserData();

    const ajaxEntryRequest = (type) => {
        let formData = {};
        formData.userEntry = type;
        const form = document.forms['entry-form'];

        if ('update' === type) {
            formData.id = form['entry-id'].value;
        }

        formData.username = form['username'].value;
        formData.email = form['email'].value;
        formData.phoneNo = form['phone-no'].value;
        formData.dob = form['dob'].value;
        formData.gender = form['gender'].value;
        formData.course = form['course'].value;
        const hobbiesArr = jQuery(form).find('input[name="hobbies"]');
        const hobbiesFilter = new Array();
        hobbiesArr.each((index, data) => {
            if (data.checked) {
                hobbiesFilter.push(data.value);
            }
        });
        formData.hobbies = hobbiesFilter;

        sendAjaxRequest(formData, updateData);
    };

    const signUp = () => {
        let formData = {};
        const form = document.forms['form-sign-up'];
        formData.username = form['username'].value;
        formData.email = form['email'].value;
        formData.password = form['password'].value;
        formData.confPassword = form['confirm_password'].value;
        formData.signUp = true;

        const callback = (response) => {

        }

        sendAjaxRequest(formData, callback);
    }

    const login = () => {
        let formData = {};
        const form = document.forms['form-sign-in'];
        formData.userName = form['username'].value;
        formData.password = form['password'].value;
        formData.login = true;

        const callback = (data) => {
            if ('user found' === data.message) {
                jQuery('.login-form').hide();
                jQuery('.user-data').show();
                getUserData();
            } else if ('user not found' === data.message) {
                alert('User Name And Password Doesn\'t match');
            }
        }

        sendAjaxRequest(formData, callback);
    }

    const logout = () => {
        let formData = {};
        formData.logout = true;

        const callback = (data) => {

            if (data.login_status) {
                jQuery('.login-form').show();
                jQuery('.user-data').hide();
                jQuery('.user-data').find('.user-data-body div').remove();
            }

            alert(data.message);
        }

        sendAjaxRequest(formData, callback);
    }

    const editFormDataUpdate = (id) => {
        let formData = {};
        formData.editData = true;
        formData.editId = id;

        const callback = (data) => {
            if (data.status) {
                const entryData = data.entry;
                const form = document.forms['entry-form'];
                form.reset();
                form['username'].value = entryData.username;
                form['email'].value = entryData.email;
                form['phone-no'].value = entryData.phone_no;
                form['dob'].value = entryData.dob;
                form['gender'].value = entryData.gender;
                form['course'].value = entryData.course;

                const hobbbiesDataArr = entryData.hobbies.split(',');

                const hobbiesArr = jQuery(form).find('input[name="hobbies"]');
                hobbiesArr.each((index, data) => {
                    if (hobbbiesDataArr.includes(data.value)) {
                        data.checked = true;
                    }
                });

                if (undefined === form['entry-id']) {
                    const hiddenField = `<input type="hidden" name="entry-id" value="${id}">`;
                    jQuery(form).prepend(hiddenField);
                } else {
                    form['entry-id'].value = id;
                }

            }
        }

        sendAjaxRequest(formData, callback);
    };

    const removeEntry = (id) => {
        let formData = {};
        formData.userDelete = true;
        formData.deleteId = id;

        const callback = (data) => {
            if (data.status) {
                const id = parseInt(data.id);
                const element = jQuery(`.user-data-body div button.delete-user-data[data-id="${id}"]`).closest('div');
                const serialNo = element.find('p')[0].innerText;
                element.remove();

                const entriesArr = jQuery('.user-data-body>div');
                if (entriesArr.length > serialNo) {
                    for (var i = (serialNo - 1); i < entriesArr.length; i++) {
                        const serialNoElemennt = entriesArr[i].querySelector('p');
                        const prevValue=serialNoElemennt.innerText;
                        serialNoElemennt.innerText = parseInt(prevValue) - 1;
                    }
                }

            } else {
                console.error(data.message);
            }
        }

        sendAjaxRequest(formData, callback);
    }

    jQuery('form[name="entry-form"] button[type="submit"]').on('click', (e) => {
        e.preventDefault();
        jQuery('#entry-form').closest('div.form-wrapper').toggleClass('active');
        const formType = jQuery(e.currentTarget).data('type');
        ajaxEntryRequest(formType);
    });
    jQuery('form[name="form-sign-in"] button[type="submit"]').on('click', (e) => {
        e.preventDefault();
        login();
    });
    jQuery('form[name="form-sign-up"] button[type="submit"]').on('click', (e) => {
        e.preventDefault();
        signUp();
    });

    jQuery('form[name="form-sign-in"] button.sign-up').on('click', (e) => {
        e.preventDefault();
        jQuery('form[name="form-sign-in"]').closest('div.form-wrapper').toggleClass('active');
        jQuery('form[name="form-sign-up"]').closest('div.form-wrapper').toggleClass('active');
    });

    jQuery('form[name="form-sign-up"] button.sign-in').on('click', (e) => {
        e.preventDefault();
        jQuery('form[name="form-sign-up"]').closest('div.form-wrapper').toggleClass('active');
        jQuery('form[name="form-sign-in"]').closest('div.form-wrapper').toggleClass('active');
    });

    jQuery('button.log-out').on('click', (e) => {
        e.preventDefault();
        logout();
    });

    jQuery(document).on('click', 'button.delete-user-data', (e) => {
        e.preventDefault();
        const id = jQuery(e.currentTarget).data('id');
        removeEntry(id);
    });

    jQuery(document).on('click', '.form-visibility', (e) => {
        const formHeading = jQuery(e.currentTarget).data('form-heading');
        const formType = jQuery(e.currentTarget).data('type');
        if ('update' === formType) {
            const id = jQuery(e.currentTarget).data('id');
            if (id && '' !== id) {
                editFormDataUpdate(id);
            }
        };
        const form = jQuery('#entry-form');
        form.closest('div.form-wrapper').addClass('active');
        form.find('button[type="submit"]').attr('data-type', formType);
        form.find('h1').text(formHeading);
    })

    jQuery('.close-button').on('click', e => {
        e.preventDefault();
        const closeId = jQuery(e.currentTarget).data('hide');
        jQuery(`#${closeId}`)[0].reset();
        jQuery(`#${closeId}`).closest('div.form-wrapper').toggleClass('active');
    });
});