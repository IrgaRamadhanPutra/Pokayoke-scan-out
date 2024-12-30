<script>
    // Deklarasi Variable
    var input1 = $("#input1");
    var input2 = $("#input2");
    var reset = $("#reset");
    $(document).ready(function() {
        // input1.focus();
        document.getElementById('input1').focus();
        // $('.form').submit(function() {
        // cek data
        function checkInput() {
            if (input1.val() != "") {
                // input1.strsubsring(0, 16)
                var a = input1.val()
                var part_no = a.slice(14, 28);
                // var job = a.slice(16, -3);
                // console.log(part_no)
                csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('validasi_yamaha') }}",
                    method: 'get',
                    dataType: 'json',
                    data: {
                        '_token': csrf_token,
                        'part_no': part_no
                        // 'job_no': job
                    },
                    success: function(data) {
                        // console.log(data);
                        var a = data['0'];
                        var b = data['0']['dn_no'];
                        var c = data['0']['quantity'];
                        var d = data['0']['part_no'];


                        // console.log(a);
                        if (data == '-') {
                            document.getElementById('Audioerror').play();
                            swal.fire({
                                icon: 'error',
                                timer: 2000,
                                title: 'Error',
                                text: 'Data Not Found',
                            });
                            $('#input1').val("");
                            $('#input1').focus();
                        } else {
                            input1.attr("readonly", true);
                            input2.attr("readonly", false);
                            input2.focus();
                            $('#dn_no').val(b);
                            $('#qty').val(c);
                            $('#part_no').val(d);
                        }
                    },

                });
            }
        }
        input1.on("keydown", function(e) {
            // var keyCode = e.which;
            // Enter
            if (event.key === "Enter") {
                checkInput();
                return false;
            }
        });

        input2.on("change", function(e) {
            if (input2.val() != "");
            {
                input1.attr("readonly", false);
                var a = input2.val();
                if (a.includes(",")) {
                    var arr = a.split(",");
                    var part_no = arr[3];
                    if (part_no.includes("-")) {
                        var d = part_no.replace(/-/g, "");
                        // console.log(d);

                    } else {
                        var d = part_no;
                    }
                } else {
                    var arr = [""];
                    input1.val("");
                    input2.val("");
                    input1.focus();
                    document.getElementById('Audioerror').play();
                    swal.fire({
                        icon: 'error',
                        timer: 2000,
                        title: 'Error',
                        text: 'Part no Tidak Sama',
                    });

                }

                // console.log(d)
                var part = document.getElementById('part_no').value;
                // var nilai1 = part.slice(0, 10);
                if (part == d) {
                    // alert('sama');
                    csrf_token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{{ route('getEkanban') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: $('#form-yamaha').serialize(),
                        success: function(data) {
                            document.getElementById('Audioerror').play();
                            if (data == "A01") {
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Tidak Ada Periode Yang Aktif  ',
                                });
                            } else if (data == "A02") {
                                document.getElementById('Audioerror').play();
                                swal.fire({
                                    icon: 'warning',
                                    timer: 2000,
                                    title: 'Perhatian',
                                    text: 'Kanban Sudah Di Submit',
                                });
                            } else if (data == "A03") {
                                document.getElementById('Audiosucces').play();
                                swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    timer: 2000,
                                    text: 'Berhasil Submit',
                                });

                            } else if (data == "A04") {
                                document.getElementById('Audioerror').play();
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Data Excel Belum di Upload ',
                                });

                            } else if (data == "A05") {
                                document.getElementById('Audioerror').play();
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Quantity Scan Sudah Melebihi Quantity Pengiriman ',
                                });

                            } else if (data == "A06") {
                                document.getElementById('Audioerror').play();
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Kanban Belum di Scan In ',
                                });

                            } else if (data == "A07") {
                                // play Audio
                                document.getElementById('Audioerror').play();
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Kanban Belum di out chuter ',
                                });

                            } else if (data == "A08") {
                                // play Audio
                                document.getElementById('Audioerror').play();
                                swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    timer: 2000,
                                    text: 'Akses terkunci ',
                                });

                            }

                        }

                    });

                } else {
                    input1.val("");
                    input2.val("");
                    input1.focus();
                    document.getElementById('Audioerror').play();
                    swal.fire({
                        icon: 'error',
                        timer: 2000,
                        title: 'Error',
                        text: 'Part no Tidak Sama',
                    });
                }
            }
            input1.val("");
            input2.val("");
            input1.focus();
        });
        // Reset Form
        reset.on("click", function() {
            reset.addClass("d-none");
            input1.attr("readonly", false);
            input1.focus();

            input1.val("")
            input2.val("")

        });
    });
</script>
