<?php
    $student_data = $student->getStudentData($_COOKIE["sid"]);
    
?>

<section id="payment-form" style="display: flex !important; padding-top:100px;">
    <section>
        <section class="payment-form-part payment-selected-student">
            <header class="d-flex justify-content-between">
                <h2>Student</h2>
            </header>
            <div class="d-flex gap-3">
                <div class="payment-form-student-pic">
                    <img src="<?= $student_data["data"]["profile_pic"] ?>" alt="" id="profile-picture" />
                </div>
                <div>
                    <p>Name: <span class="h3 mb-2" id="profile-name"><?= $student_data["data"]["firstname"] ?> <?= $student_data["data"]["lastname"] ?></span></p>
                    <p>Student Number: <span id="profile-student-number"><?= $student_data["data"]["student_id"] ?></span></p>
                    <p>Year/Course: <span id="profile-year-course"><?= $student_data["data"]["year_section"] ?></span></p>
                </div>
                <div class="d-flex gap-4 align-items-end">
                    <p>Total Paid: <span class="h5" id="total-paid"> <?= $student_data["total_paid"] ?></span> php</p>
                    |
                    <p>Total balance: <span class="h5" id="total-balance">  <?= $student_data["total_balance"] ?></span> php</p>
                </div>
            </div>
        </section>
        <section class="payment-form-part payment-main-form mt-5">
            <header class="d-flex justify-content-center align-items-center text-center">
                <div class="payment-form-student-pic">
                    <img src="./assets/img/CRT2.webp" alt="CRT logo" />
                </div>
                <div>
                    <h2>College For Research & Technology</h2>
                    <ul class="d-flex flex-wrap text-center school-details">
                        <li>Beedle St., Burgos, Cabanatuan City</li>
                        <li>0463-2697</li>
                        <li>600-220</li>
                        <li>611-040463</li>
                        <li>Telefax: 463-2735</li>
                        <li>486-7565; e-mail:crtcab@yahoo.com.ph</li>
                        <li>Gapan: 486-7565</li>
                        <li>Guimba: 958-1454</li>
                        <li>San Jose: 958-1870; email add: crt.cabanatuan@gmail.com</li>
                    </ul>
                </div>
            </header>
            <form action="./index.php" class="mt-2" id="main-payment-form" method="POST">
                <input type="hidden" name="update-charges-detail" />
                <section class="d-flex align-items-center gap-1">
                    <div class="d-flex align-items-center gap-1" style="flex: 1 1 !important">
                        <label>Student No.</label>
                        <input type="text" name="student-number" value="<?= $student_data["data"]["student_id"] ?>" id="payment-student-id-input" class="form-control" style="flex: 1 1 !important" readonly />
                    </div>
                    <div class="d-flex align-items-center gap-1" style="flex: 1 1 !important">
                        <label>Date:</label>
                        <input type="text" id="payment-date-input" name="payment-date-input" value="<?= !$student_data["charges"] ? '' : $student_data["charges"]["date"] ?>" class="form-control" style="flex: 1 1 !important" readonly/>
                    </div>
                    <div class="d-flex align-items-center gap-1" style="flex: 1 1 !important">
                        <label>Course</label>
                        <input type="text" id="payment-course-input" value=" <?= $student_data["data"]["year_section"] ?>" class="form-control" style="flex: 1 1 !important" readonly />
                    </div>
                </section>
                <section class="d-flex align-items-center mt-3">
                    <div class="d-flex align-items-center me-1">
                        <label for="">Name:</label>
                    </div>
                    <div class="d-flex align-items-center" style="flex: 1 1 !important">
                        <input type="text" value="<?= $student_data["data"]["firstname"] ?>" name="" id="payment-firstname-input" class="form-control" style="flex: 1 1 !important" placeholder="Last" readonly />
                    </div>
                    <div class="d-flex align-items-center" style="flex: 1 1 !important">
                        <input type="text" value="<?= $student_data["data"]["lastname"] ?>" id="payment-lastname-input" class="form-control" style="flex: 1 1 !important" placeholder="First" readonly readonly />
                    </div>
                    <div class="d-flex align-items-center" style="flex: 1 1 !important">
                        <input type="text" value="<?= $student_data["data"]["middle"] ?>" id="payment-middlename-input" class="form-control" style="flex: 1 1 !important" placeholder="Middle" readonly readonly />
                    </div>
                </section>
                <p class="h3 text-center m-3">Charges</p>
                <section class="d-flex align-items-center justify-content-between gap-2 mt-3" style="flex-wrap: wrap" id="charges-details">
                    <div class="d-flex align-items-center w-100">
                        <label for="">Registration fee:</label>
                        <input type="number" value="<?= !$student_data["charges"] ? 0.0 : $student_data["charges"]["registration_fee"] ?>" name="charges-registration-fee" class="form-control" placeholder="0.00" id="charges-registration-fee" required readonly />
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="">Tuition fee:</label>
                        <input type="number" value="<?= !$student_data["charges"] ? 0.0 : $student_data["charges"]["tuition_fee"] ?>" name="charges-tuition-fee" class="form-control" placeholder="0.00" id="charges-tuition-fee" required readonly />
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="">Laboratory fee:</label>
                        <input type="number" value="<?= !$student_data["charges"] ? 0.0 : $student_data["charges"]["laboratory_fee"] ?>" name="charges-laboratory-fee" class="form-control" placeholder="0.00" id="charges-laboratory-fee" required readonly />
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="">Miscelleneous fee:</label>
                        <input type="number" value="<?= !$student_data["charges"] ? 0.0 : $student_data["charges"]["miscelleneous_fee"] ?>" name="charges-miscelleneous-fee" class="form-control" placeholder="0.00" id="charges-miscelleneous-fee" required readonly />
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="">Others fee:</label>
                        <input type="number" value="<?= !$student_data["charges"] ? 0.0 : $student_data["charges"]["others_fee"] ?>" name="charges-others-fee" class="form-control" placeholder="0.00" id="charges-others-fee" required readonly />
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="">Amount Due:</label>
                        <input type="number" value="<?= !$student_data["charges"] ? 0.0 : $student_data["charges"]["total"] ?>" id="charges-total-fee" class="form-control" placeholder="0.00" required readonly />
                    </div>
                </section>
                <p class="h3 text-center m-3">Payments</p>
                <section id="payment-record">
                    <?php
                        if(count($student_data["payments"]) > 0){
                            array_map(function($payment){
                                echo '
                                    <section class="d-flex align-items-center justify-content-between gap-2 mt-3" style="flex-wrap: wrap" class="payment-details" readonly>
                                        <div class="d-flex align-items-center">
                                            <label for="">OR:</label>
                                            <input type="number" value="'.$payment["payment_or"].'" id="new-or-input" class="form-control" placeholder="0000"  readonly/>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label for="">Amount:</label>
                                            <input type="number" value="'.$payment["amount"].'" id="new-amount-input" class="form-control" placeholder="0.00"  readonly/>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label for="">Date:</label>
                                            <input type="text" value="'.$payment["date"].'" id="new-date-input" class="form-control" placeholder="0.00" readonly />
                                        </div>
                                    </section>
                                ';
                            },$student_data["payments"]);
                        }else{
                            echo '<h3 class="h3 text-center" style="color: #555;">No payment record yet</h3>';
                        }
                        
                    ?>
                </section>
                
            </form>
        </section>
    </section>
</section>
<!-- Custome script -->
<script>
    
</script>
