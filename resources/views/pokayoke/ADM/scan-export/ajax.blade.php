<script>
    // Deklarasi Variable
    var input1 = $("#input1");
    var input2 = $("#input2");
    var reset = $("#reset");

    // Input field 1
    $(document).ready(function() {
        input1.focus();
        // Event Keydown untuk keyboard lalu jalankan function
        input1.on("keydown", function(e) {
            // Enter
            if (e.key === "Enter") {
                checkInput();
                return false;
            }
        });

        function checkInput() {
            var inputVal = input1.val(); // Gunakan variabel baru untuk menyimpan nilai input
            if (inputVal.includes('#')) {
                var spliteData = inputVal.split('#');
                console.log(spliteData);
                var modulNo = spliteData[0];
                var partNo = spliteData[1];
                $('#part_no').val(partNo);
                // validias modul no to gohin adm
                csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('validasi_gohin') }}",
                    method: 'get',
                    dataType: 'json',
                    data: {
                        '_token': csrf_token,
                        'modulNo': modulNo,
                        'partNo': partNo
                    },
                    success: function(data) {
                        if (data === '-') {
                            document.getElementById('Audioerror').play();
                            swal.fire({
                                icon: 'error',
                                timer: 2000,
                                title: 'Data Not Found',
                                text: 'DN No & Part No Data Not Found',
                            });
                            $('#input1').val("");
                            $('#input1').focus();
                        } else {
                            $('#input1').attr("readonly", true);
                            $('#input2').attr("readonly", false).focus();

                            // Memasukkan data ke input fields
                            $('#dn_no').val(data.dn_no);
                            $('#job_no').val(data.job_no);

                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + error);
                    }
                });
                // Lakukan sesuatu dengan partNo jika diperlukan
            } else {
                document.getElementById('Audioerror').play();
                swal.fire({
                    icon: 'error',
                    timer: 2000,
                    title: 'Error',
                    text: 'Format Tidak Sesuai',
                });
                $('#input1').val("");
                $('#input1').focus();
                input1.attr("readonly", false);
                document.getElementById('part_no').value = '';
            }
        }

        input2.on("change", function(e) {
            var inputVal = input2.val(); // Store the value of input2
            if (inputVal.includes(',')) {
                var spliteData = inputVal.split(',');
                // console.log(spliteData);
                var partNoinput2 = spliteData[2];
                var partNoinput1 = document.getElementById('part_no').value;
                // console.log(partNoinput1);
                // console.log(partNoinput2);

                // document.getElementById('Audioerror').play();
                $('.loading-spinner-container').hide();
                if (partNoinput1 == partNoinput2) {

                    // alert('part no sma');
                    $('.loading-spinner-container').show();
                    csrf_token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{{ route('getEkanbanAdmoutSp1Export') }}",
                        method: 'GET',
                        dataType: 'json',
                        data: $('#form').serialize(),
                        success: function(response) {
                            // The response data will be available in response.data
                            var data = response.data;


                            $('.loading-spinner-container').hide();
                            resetInputValues()
                            if (data == "A01") {
                                 document.getElementById('Audioerror')
                                .play();
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Tidak Ada Periode Yang Aktif  ',
                                });

                            } else if (data == "A02") {
                                // play Audio
                                document.getElementById(
                                    'Audioerror').play();
                                    // resetInputValues()
                                swal.fire({
                                    icon: 'warning',
                                    timer: 2000,
                                    title: 'Perhatian',
                                    text: 'Kanban Sudah Di Submit',
                                });

                            } else if (data == "A03") {
                                // play Audio

                                document.getElementById(
                                    'Audiosucces').play();
                                    // resetInputValues()
                                swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    timer: 2000,
                                    text: 'Berhasil Submit',
                                });

                            } else if (data == "A04") {
                                // play Audio
                                document.getElementById(
                                    'Audioerror').play();
                                    // resetInputValues()
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Data Excel Belum di Upload ',
                                });

                            } else if (data == "A05") {
                                // play Audio
                                document.getElementById(
                                    'Audioerror').play();
                                    // resetInputValues()
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Quantity Scan Sudah Melebihi Quantity Pengiriman ',
                                });

                            } else if (data == "A06") {
                                // play Audio
                                document.getElementById(
                                    'Audioerror').play();
                                    // resetInputValues()
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Kanban Belum di Scan In ',
                                });

                            } else if (data == "A07") {
                                // play Audio
                                document.getElementById(
                                    'Audioerror').play();
                                    // resetInputValues()
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Kanban Belum di out chuter ',
                                });

                            } else if (data == "A08") {
                                // play Audio
                                document.getElementById(
                                    'Audioerror').play();
                                    // resetInputValues()
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Akses terkunci ',
                                });

                                input1.focus();
                            }

                        }
                    });

                } else {
                    resetInputValues()
                    document.getElementById('Audioerror').play();
                    swal.fire({
                        icon: 'error',
                        timer: 2000,
                        title: 'Error',
                        text: 'Part no Tidak Sama',
                    });
                    input1.focus();
                }
            } else {
                document.getElementById('Audioerror').play();
                swal.fire({
                    icon: 'error',
                    timer: 2000,
                    title: 'Error',
                    text: 'Invalid format',
                }).then(() => {
                    // Ensure input1 is focused after the alert is dismissed
                    resetInputValues();
                    $('#input1').attr("readonly", false).focus();
                    input1.focus();
                });
            }
        });

        // function resetInputValues() {
        //     // Clear input values and manage focus
        //     $('#dn_no').val('');
        //     $('#job_no').val('');
        //     $('#part_no').val('');
        //     $('#input1').val('');
        //     $('#input2').val('');
        // }


        //functon reset
        function resetInputValues() {
            // Reset nilai dari masing-masing input field
            $('#input1').val("");
            $('#input1').focus();
            input1.attr("readonly", false);
            document.getElementById('dn_no').value = '';
            document.getElementById('job_no').value = '';
            document.getElementById('part_no').value = '';
            document.getElementById('input1').value = '';
            document.getElementById('input2').value = '';
        }

        // Reset Form
        reset.on("click", function() {
            reset.addClass("d-none");
            input1.attr("readonly", false);
            input1.focus();
            input1.val("");
            input2.val("");
            document.getElementById('dn_no').value = '';
            document.getElementById('job_no').value = '';
        });
    });
</script>
