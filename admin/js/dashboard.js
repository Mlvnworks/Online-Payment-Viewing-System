const studentItems = document.querySelectorAll('.student-item');
const loadingModal = document.querySelector('.loading');
const studentAccountModal = document.querySelector('#payment-form');
const studentListContainer = document.querySelector('.student-list');
const studentList = document.querySelector('.student-list');
const studentListLoading = document.querySelector('#student-list-loading');
const searchStudentInput = document.querySelector('#student-search-input');

const triggerCount = 748;

let studentSet = 1;

// Dashboard state
const openState = state => {
    switch (state) {
        case 'loading':
            loadingModal.style.display = 'none';
            studentAccountModal.style.display = 'none';
            break;
        case 'loaded':
            loadingModal.style.display = 'none';
            studentAccountModal.style.display = 'flex';
            break;
        default:
            loadingModal.style.display = 'none';
            studentAccountModal.style.display = 'none';
            break;
    }
};

// Fetch sets Student
const getSetStudent = async () => {
    studentList.removeEventListener('scroll', fetchScroll);
    const request = await fetch(`./?get-student-list=0&page=${studentSet}`);
    const datas = await request.json();

    if (studentSet === 1 && datas.data.length <= 0) {
        studentList.innerHTML = `
            <h1 class="h1 text-light text-center" style="text-shadow:3px 3px 5px #222">No registered student</h1>
        `;
        return;
    }

    if (datas.data.length <= 0) {
        return;
    }

    // Show Fetched Data
    datas.data.forEach(data => {
        const div = document.createElement('div');
        div.className = 'student-item';
        div.setAttribute('data-student-id', data.student_id);

        div.innerHTML = `
            <div class="student-pic">
                <img src="${data.profile_pic}" alt="Student profile pic">
            </div>
            <div class="student-info">
                <p class="student-name">Name: ${data.firstname} ${data.lastname}</p>
                <p>Student Number: ${data.student_id}</p>
                <p>Course/year: ${data.year_section}</p>
            </div>
            <div class="options">
                <button class="btn btn-primary btn-sm account-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                    </svg>
                    Account
                </button>
                <button class="btn btn-success btn-sm edit-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                    Edit
                </button>
                <button class="btn btn-danger btn-sm delete-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                    </svg>
                    Delete
                </button>
            </div>
        `;

        studentListContainer.append(div);
    });

    // Select all student items
    const studentItems = document.querySelectorAll('.student-item');
    // Add event on every student item
    studentItems.forEach(student => {
        const accountBtn = student.querySelector('.account-btn');
        const deleteBtn = student.querySelector('.delete-btn');
        const editBtn = student.querySelector('.edit-btn');
        const studentId = student.getAttribute('data-student-id');

        editBtn.addEventListener('click', () => editAccount(studentId));
        accountBtn.addEventListener('click', () => openAccount(studentId));
        deleteBtn.addEventListener('click', () => deleteAccount(studentId));
    });

    studentSet++;
    studentList.addEventListener('scroll', fetchScroll);
};

const fetchScroll = e => {
    const currentScroll = studentList.scrollTop;
    if (currentScroll + triggerCount >= studentList.scrollHeight) {
        getSetStudent();
    }
};

// Fetch another set of students when reachers end
studentList.addEventListener('scroll', fetchScroll);

// Edit account
const editAccount = async id => {
    const getStudentData = await fetch(`./?get-student-data=${id}`);
    const studentData = await getStudentData.json();

    const { student_id, firstname, middle, lastname, year_section, profile_pic, address, email } = studentData.data.data;

    const editAccountForm = document.querySelector('#update-student-form');
    const closeEditAccountForm = document.querySelector('#close-edit-account-form');
    const studentId = document.querySelector('#update-student-id');
    const studentFirstname = document.querySelector('#update-firstname');
    const studentLastname = document.querySelector('#update-lastname');
    const studentMiddlename = document.querySelector('#update-middlename');
    const studentYearSection = document.querySelector('#update-year-section');
    const studentAddress = document.querySelector('#update-address');
    const studentEmail = document.querySelector('#update-email');
    const studentProfile = document.querySelector('#binary-url-input');

    studentId.value = student_id;
    studentFirstname.value = firstname;
    studentLastname.value = lastname;
    studentMiddlename.value = middle;
    studentYearSection.value = year_section;
    studentAddress.value = address;
    studentEmail.value = email;
    studentProfile.value = profile_pic;

    const fileInput = document.querySelector('#file-input');
    const binaryUrlInput = document.querySelector('#binary-url-input');

    fileInput.addEventListener('change', e => {
        const file = e.target.files[0];

        // Check file type
        if (!file.type.includes('image')) return window.alert('Please select and valid profile image.');

        const fReader = new FileReader();
        fReader.readAsDataURL(file);
        fReader.onload = () => {
            binaryUrlInput.value = fReader.result;
        };
    });

    closeEditAccountForm.addEventListener('click', () => {
        editAccountForm.style.display = 'none';
    });

    editAccountForm.style.display = 'flex';
};

async function removeRecord(button) {
    const targetOr = button.getAttribute('data-or');
    const targetID = button.getAttribute('data-id');
    const parentElement = button.parentElement.parentElement;

    const deletePaymentRecord = await fetch(`./?remove-payment=${targetOr}`);
    const getTotalBalance = await fetch(`./?get-student-data=${targetID}`);

    const {
        data: { total_balance },
    } = await getTotalBalance.json();
    const result = await deletePaymentRecord.json();
    document.querySelector('#total-paid').textContent = !result.total_paid ? 0.0 : result.total_paid;
    document.querySelector('#total-balance').textContent = total_balance;
    parentElement.remove();
}

// delete account
const deleteAccount = id => {
    if (window.confirm(`Are you sure your want to delete student ${id}`)) {
        location.href = `./?delete_student=${id}`;
    }
};

// Open account
const openAccount = async id => {
    // Start loading screen
    openState('loading');
    const getStudentData = await fetch(`./?get-student-data=${id}`);
    const studentData = await getStudentData.json();

    const { firstname, lastname, student_id, year_section, profile_pic, middle } = studentData.data.data;

    //Update Profile Datas
    const profileName = document.querySelector('#profile-name');
    const profileStudentNumber = document.querySelector('#profile-student-number');
    const profileYearCourse = document.querySelector('#profile-year-course');
    const profilePicture = document.querySelector('#profile-picture');

    profilePicture.src = profile_pic;
    profileName.textContent = `${firstname} ${lastname}`;
    profileStudentNumber.textContent = student_id;
    profileYearCourse.textContent = year_section;

    // Update Payment Details profile
    const paymentStudentIdInput = document.querySelector('#payment-student-id-input');
    const paymentDateInput = document.querySelector('#payment-date-input');
    const paymentCourseInput = document.querySelector('#payment-course-input');
    const paymentFirstnameInput = document.querySelector('#payment-firstname-input');
    const paymentLastnameInput = document.querySelector('#payment-lastname-input');
    const paymentMiddlenameInput = document.querySelector('#payment-middlename-input');
    const saveBtn = document.querySelector('#save-btn');
    const mainPaymentForm = document.querySelector('#main-payment-form');

    paymentStudentIdInput.value = student_id;
    paymentCourseInput.value = year_section;
    paymentFirstnameInput.value = firstname;
    paymentLastnameInput.value = lastname;
    paymentMiddlenameInput.value = middle;

    // Charges Details
    const chargesRegistrationFee = document.querySelector('#charges-registration-fee');
    const chargesTuitionFee = document.querySelector('#charges-tuition-fee');
    const chargesLaboratoryFee = document.querySelector('#charges-laboratory-fee');
    const chargesMiscelleneousFee = document.querySelector('#charges-miscelleneous-fee');
    const chargesOthersFee = document.querySelector('#charges-others-fee');
    const chargesTotalFee = document.querySelector('#charges-total-fee');
    let totalAmount = 0.0;

    const calculateTotalAmount = () => {
        totalAmount =
            parseFloat(chargesRegistrationFee.value !== '' ? chargesRegistrationFee.value : 0) +
            parseFloat(chargesTuitionFee.value !== '' ? chargesTuitionFee.value : 0) +
            parseFloat(chargesLaboratoryFee.value !== '' ? chargesLaboratoryFee.value : 0) +
            parseFloat(chargesMiscelleneousFee.value !== '' ? chargesMiscelleneousFee.value : 0) +
            parseFloat(chargesOthersFee.value !== '' ? chargesOthersFee.value : 0);

        chargesTotalFee.value = totalAmount;
    };

    saveBtn.addEventListener('click', () => {
        if (
            chargesRegistrationFee.value === '' ||
            chargesTuitionFee.value === '' ||
            chargesLaboratoryFee.value === '' ||
            chargesMiscelleneousFee.value === '' ||
            chargesOthersFee.value === '' ||
            chargesTotalFee.value === '' ||
            paymentDateInput.value === ''
        ) {
            alert('Please enter all fields');
        } else {
            mainPaymentForm.submit();
        }
    });

    chargesRegistrationFee.addEventListener('input', calculateTotalAmount);
    chargesTuitionFee.addEventListener('input', calculateTotalAmount);
    chargesLaboratoryFee.addEventListener('input', calculateTotalAmount);
    chargesMiscelleneousFee.addEventListener('input', calculateTotalAmount);
    chargesOthersFee.addEventListener('input', calculateTotalAmount);

    // Show charges details
    if (studentData.data.charges) {
        const { date, registration_fee, tuition_fee, laboratory_fee, others_fee, miscelleneous_fee, total } = studentData.data.charges;

        paymentDateInput.value = new Date(date).toISOString().split('T')[0];
        chargesRegistrationFee.value = registration_fee;
        chargesTuitionFee.value = tuition_fee;
        chargesLaboratoryFee.value = laboratory_fee;
        chargesMiscelleneousFee.value = miscelleneous_fee;
        chargesOthersFee.value = others_fee;
        chargesTotalFee.value = total;
    } else {
        chargesRegistrationFee.value = 0.0;
        chargesTuitionFee.value = 0.0;
        chargesLaboratoryFee.value = 0.0;
        chargesMiscelleneousFee.value = 0.0;
        chargesOthersFee.value = 0.0;
        paymentDateInput.value = 0.0;
        chargesTotalFee.value = 0.0;
    }

    // Payment records
    const paymentRecordContainer = document.querySelector('#payment-record');
    const addPaymentBtn = document.querySelector('#add-payment-btn');
    const totalPaidOutput = document.querySelector('#total-paid');
    const totalBalance = document.querySelector('#total-balance');

    totalBalance.textContent = studentData.data.total_balance;
    totalPaidOutput.textContent = !studentData.data.total_paid ? 0.0 : studentData.data.total_paid;

    paymentRecordContainer.innerHTML = '';
    const addPaymentRecord = async () => {
        addPaymentBtn.removeEventListener('click', addPaymentRecord);
        const newOrInput = document.querySelector('#new-or-input');
        const newAmountInput = document.querySelector('#new-amount-input');
        const newDateInput = document.querySelector('#new-date-input');

        if (newOrInput.value === '' || newAmountInput.value === '' || newDateInput.value === '') return alert('Fill all fields!');

        const sendPayment = await fetch(`./?add-payment=${student_id}&or=${newOrInput.value}&amount=${newAmountInput.value}&date=${newDateInput.value}`);
        const getTotalBalance = await fetch(`./?get-student-data=${id}`);

        const {
            data: { total_balance },
        } = await getTotalBalance.json();
        const state = await sendPayment.json();
        if (state.err) return;

        const recordItem = document.createElement('section');
        recordItem.className = 'd-flex align-items-center justify-content-between gap-2 mt-3';

        recordItem.innerHTML = `
            <div class="d-flex align-items-center">
                <label for="">OR:</label>
                <input type="number" class="form-control" placeholder="0000" value="${newOrInput.value}" readonly />
            </div>
            <div class="d-flex align-items-center">
                <label for="">Amount:</label>
                <input type="number" class="form-control" placeholder="0.00" value="${newAmountInput.value}" readonly />
            </div>
            <div class="d-flex align-items-center">
                <label for="">Date:</label>
                <input type="text" class="form-control" placeholder="" value="${newDateInput.value}" readonly />
            </div>
            <div>
                <button type="button" data-id="${student_id}" data-or="${newOrInput.value}" onClick="removeRecord(this)" class="btn btn-danger btn-sm">Remove</button>
            </div>
        `;

        newOrInput.value = '';
        newAmountInput.value = '';
        newDateInput.value = '';
        totalPaidOutput.textContent = state.total_paid;
        totalBalance.textContent = total_balance;
        paymentRecordContainer.append(recordItem);
        addPaymentBtn.addEventListener('click', addPaymentRecord);
    };

    studentData.data.payments.forEach(({ amount, student_id, payment_or, date }) => {
        const recordItem = document.createElement('section');
        recordItem.className = 'd-flex align-items-center justify-content-between gap-2 mt-3';

        recordItem.innerHTML = `
            <div class="d-flex align-items-center">
                <label for="">OR:</label>
                <input type="number" class="form-control" placeholder="0000" value="${payment_or}" readonly />
            </div>
            <div class="d-flex align-items-center">
                <label for="">Amount:</label>
                <input type="number" class="form-control" placeholder="0.00" value="${amount}" readonly />
            </div>
            <div class="d-flex align-items-center">
                <label for="">Date:</label>
                <input type="text" class="form-control" placeholder="" value="${date}" readonly />
            </div>
            <div>
                <button type="button" data-id="${student_id}" data-or="${payment_or}" onClick="removeRecord(this)" class="btn btn-danger btn-sm">Remove</button>
            </div>
        `;

        paymentRecordContainer.append(recordItem);
    });

    addPaymentBtn.addEventListener('click', addPaymentRecord);
    // Open profile modal
    openState('loaded');
};

const search = async keyword => {
    const searchStudents = await fetch(`./?search-student=${keyword}`);
    const searchResults = await searchStudents.json();

    if (searchResults.data.length <= 0) {
        studentList.innerHTML = `
            <h1 class="h1 text-light text-center" style="text-shadow:3px 3px 5px #222">Cannot find student</h1>
        `;
        return;
    }

    studentListContainer.innerHTML = '';

    searchResults.data.forEach(data => {
        const div = document.createElement('div');
        div.className = 'student-item';
        div.setAttribute('data-student-id', data.student_id);

        div.innerHTML = `
            <div class="student-pic">
                <img src="${data.profile_pic}" alt="Student profile pic">
            </div>
            <div class="student-info">
                <p class="student-name">Name: ${data.firstname} ${data.lastname}</p>
                <p>Student Number: ${data.student_id}</p>
                <p>Course/year: ${data.year_section}</p>
            </div>
            <div class="options">
                <button class="btn btn-primary btn-sm account-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                    </svg>
                    Account
                </button>
                <button class="btn btn-success btn-sm edit-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                    Edit
                </button>
                <button class="btn btn-danger btn-sm delete-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                    </svg>
                    Delete
                </button>
            </div>
        `;

        studentListContainer.append(div);
    });

    // Select all student items
    const studentItems = document.querySelectorAll('.student-item');
    // Add event on every student item
    studentItems.forEach(student => {
        const accountBtn = student.querySelector('.account-btn');
        const deleteBtn = student.querySelector('.delete-btn');
        const editBtn = student.querySelector('.edit-btn');
        const studentId = student.getAttribute('data-student-id');

        accountBtn.addEventListener('click', () => openAccount(studentId));
        deleteBtn.addEventListener('click', () => deleteAccount(studentId));
        editBtn.addEventListener('click', () => editAccount(studentId));
    });
    studentListLoading.remove();
};

// Search Student
searchStudentInput.addEventListener('input', e => {
    if (e.target.value.trim() === '') return location.reload();

    // Fetch another set of students when reachers end
    studentList.removeEventListener('scroll', fetchScroll);
    studentList.innerHTML = ``;
    studentList.append(studentListLoading);
    search(e.target.value);
});

getSetStudent();

window.onload = () => {
    studentListLoading.remove();
};
