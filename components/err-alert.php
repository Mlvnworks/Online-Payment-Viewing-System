<?php
function showAlert($state){
    if($state["err"] === false){
        return '<section id="err-alert">
                <section>
                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z" />
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z" />
                    </svg>
                    <p>'.$state["msg"].'</p>
                    <button class="btn btn-primary text-light" id="close-btn">Ok</button>
                </section>
            </section>
            <script>
                const errModal = document.querySelector("#err-alert");
                const closeErrBtn = document.querySelector("#close-btn");

                closeErrBtn.addEventListener("click", () => {
                    errModal.remove()
                })
            </script>
            ';
    }else{
        return '<section id="err-alert">
                <section>
                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
                        <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg>
                    <p>'.$state["msg"].'</p>
                    <button class="btn btn-primary text-light" id="close-btn">Ok</button>
                </section>
            </section>
            <script>
                const errModal = document.querySelector("#err-alert");
                const closeErrBtn = document.querySelector("#close-btn");

                closeErrBtn.addEventListener("click", () => {
                    errModal.remove()
                })
            </script>
        ';
    }
    
}   
?>

