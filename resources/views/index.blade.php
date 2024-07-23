<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practice</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>

</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <form id="employeeForm">
                    @csrf <!-- Laravel CSRF token -->

                    <input type="hidden" id="employee_id" name="id"> <!-- Hidden input for employee_id -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enter Name</label>
                                <input type="text" name="name" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enter Email</label>
                                <input type="text" name="email" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enter Phone</label>
                                <input type="text" name="phone" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enter Address</label>
                                <input type="text" name="address" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="button" id="submitBtn" onclick="empSubmit()" class="btn btn-primary" value="Submit" />
                            <input type="button" id="updateBtn" onclick="empUpdate()" class="btn btn-info" value="Update" style="display: none;"/>
                        </div>
                    </div>
                </form>

            </div>
        </div>


        <div class="row mt-5">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script>

                    function getData(){
                        fetch(`{{url('show')}}`)
                        .then(response => response.json())
                        .then(json => {

                            let tr = "";
                            for(let i of json.show){
                                tr += `<tr>
                                <td>${i.id}</td>
                                <td>${i.name}</td>
                                <td>${i.email}</td>
                                <td>${i.phone}</td>
                                <td>${i.address}</td>
                                <td><button type="button" onclick="editData(${i.id})" class='btn btn-info'>Edit</button></td>
                                <td><button type="button" onclick="delData(${i.id})" class='btn btn-danger'>Delete</button></td>
                            </tr>`
                            }
                            document.getElementById('tbody').innerHTML= tr
                        })
                    }

                    getData();
                    // function editData(id) {
                    //     fetch(`{{ url('edit') }}/${id}`)
                    //     .then(response => response.json())
                    //     .then(json => {
                    //         $('input[name="name"]').val(data.name);
                    //         document.querySelector('input[name="name"]').value = json.name;
                    //         document.querySelector('input[name="email"]').value = json.email;
                    //         document.querySelector('input[name="phone"]').value = json.phone;
                    //         document.querySelector('input[name="address"]').value = json.address;
                    //         document.getElementById('submitBtn').style.display = 'none';
                    //         document.getElementById('updateBtn').style.display = 'block';
                    //     });
                    // }

                    function empSubmit(){
                        const form = document.getElementById('employeeForm')
                        const formData = new FormData(form);

                        $.ajax({
                            url : `{{route('post_emp')}}`,
                            type : 'post',
                            data : formData,
                            contentType : false,
                            processData : false,
                            success:function(res){
                              form.reset();
                              getData();
                            },
                            error:function(err){
                                console.log(err)
                            }

                        })

                    }


                    function editData(id) {
                        fetch(`{{ url('edit') }}/${id}`)
                            .then(response => response.json())
                            .then(json => {
                                $('#employee_id').val(json.id); // Ensure this sets the employee_id field
                                $('input[name="id"]').val(json.id);
                                $('input[name="name"]').val(json.name);
                                $('input[name="email"]').val(json.email);
                                $('input[name="phone"]').val(json.phone);
                                $('input[name="address"]').val(json.address);

                                $('#submitBtn').hide();
                                $('#updateBtn').show();
                            });
                    }

                    function empUpdate() {
                        const form = document.getElementById('employeeForm');
                        const employeeId = $('#employee_id').val(); // Retrieve employee_id from input field
                        const formData = new FormData(form);

                        // Fetch CSRF token from the meta tag
                        const csrfToken = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            url: `{{ url('update') }}/${employeeId}`, // Make sure employeeId is defined and correct
                            type: 'PUT',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
                            },
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                form.reset(); // Reset the form after successful update
                                getData(); // Refresh the data table after update
                                $('#submitBtn').show(); // Show the submit button again
                                $('#updateBtn').hide(); // Hide the update button
                            },
                            error: function(error) {
                                console.error('Error:', error);
                            }
                        });
                    }




                    function delData(id){
                        $.ajax({
                            url : `{{route('del_emp')}}`,
                            type : 'get',
                            data : {
                                id : id
                            },
                            success:function(){
                                getData()
                            }
                        })
                    }




                </script>
    </body>
</html>
