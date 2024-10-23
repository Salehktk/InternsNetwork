<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 50px;
            background-color: #f0f2f5;
            color: #333;
            line-height: 1.6;
        }

        .form-container {
            background-color: #ffffff88;
            border-top: 10px solid #4159A0;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
            transition: all 0.3s ease-in-out;
        }

        .form-container:hover {
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
        }

        .form-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #4159A0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="file"]:focus {
            border-color: #4159A0;
            box-shadow: 0 0 8px rgba(92, 184, 92, 0.3);
            outline: none;
        }
        button.btn.btn-secondary {
            width: 100%;
        }
        .form-group button,
        .form-group a.btn {
            background-color: #4159A0;
            color: white;
            
            margin-bottom: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .form-group button:hover,
        .form-group a.btn:hover {
            background-color: #4159A0;
            transform: translateY(-2px);
        }

        .form-group button:active,
        .form-group a.btn:active {
            background-color: #4159A0;
            transform: translateY(0);
        }

        .img-thumbnail {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
        }

        .form-group input[type="file"]::file-selector-button {
            background-color: #4159A0;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .form-group input[type="file"]::file-selector-button:hover {
            background-color: #4159A0;
        }
        
        /**/
        
        
           .custom-file-input, .custom-file-input2 {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .custom-file-input input[type="file"], .custom-file-input2 input[type="file"] {
            display: none;
        }

        .custom-file-label, .custom-file-label2 {
            border: 1px solid #304890;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            background-color: #304890;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            transition: background-color 0.3s;
            width: 100%;
            box-sizing: border-box;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .custom-file-label:hover, .custom-file-label2:hover {
            background-color: #253a70;
        }
        @media (max-width: 600px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>

</head>

<body>

   {{-- @dd($coachdata); --}}
    <div class="form-container">
        <h2 style="text-align: center">Coach Data</h2>
        <form action="{{ route('coachingdataStore') }}" method="post" enctype="multipart/form-data">
            @csrf

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif



            <!-- Name dropdown with Select2 -->
            <div class="form-group">
                <label for="client"> <i class="fa fa-user" aria-hidden="true"></i> Select Coach:</label>
                <select id="coach" class="js-example-tags form-control" name="Name" multiple="multiple" required style="width:100%">
                    <option value="" disabled>Please select</option>
                    @foreach ($values as $value)
                        @if (!empty($value['Name']))
                            <option value="{{ $value['Name'] }}">{{ $value['Name'] }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {{-- <label for="email">Email:</label> --}}

                <input type="text" id="coachmail" name="coachmail" readonly>
            </div>         
              
              
           <div class="form-group">
                 <label for="pdfUpload"><i class="fas fa-upload"></i> Upload Resume in PDF Format:</label>
                    <a id="existing_pdf" href="" target="_blank" class="btn btn-info" style="display:none;">View PDF</a>
        
                     <label class="custom-file-input">
                <span class="custom-file-label">Choose PDF File</span>
              <input type="file" id="pdf_path" name="pdf_path" accept="application/pdf">
             </label>
            </div>

            <div class="form-group">
                <!--<label for="image_path"> <i class="fas fa-image"></i> Upload Image:</label>-->
                <!--<img id="existing_image" src="" alt="Existing Image" class="img-thumbnail" style="display:none;  margin-top: 10px;">-->
                <!--<input type="file" id="image_upload" name="image_path" accept="image/*" class="form-control">-->
                
                
                <label for="image_path"><i class="fas fa-upload"></i> Upload Image:</label>
                   <img id="existing_image" src="" alt="Existing Image" class="img-thumbnail" style="display:none;  margin-top: 10px;">
        
                     <label class="custom-file-input2">
                <span class="custom-file-label2">Choose Image </span>
              <input type="file" id="image_upload" name="image_path" accept="image/*">
             </label>
                
                
            </div>

            <input type="hidden" name="existing_pdf_path" id="existing_pdf_path">
            <input type="hidden" name="existing_image_path" id="existing_image_path">
            <div class="form-group">
                <button type="submitt" class="btn btn-secondary">Submit</button>

            </div>

        </form>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.min.js"></script>
    <!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
    //   document.getElementById('pdf_upload').addEventListener('change', function(event) {
    //         var fileName = event.target.files[0]?.name || "Choose PDF File";
    //         document.querySelector('.custom-file-label').textContent = fileName;
    //     });


        $(document).ready(function() {
        $('.js-example-tags').select2({
            tags: true,
            maximumSelectionLength: 1, 
            allowClear: true
        });

        @if (isset($coachdata))
            const coachdata = {!! json_encode($coachdata) !!};

            $('#coach').change(function() {
                const selectedCoach = $(this).val();
                if (selectedCoach && coachdata[selectedCoach]) {
                    $('#coachmail').val(coachdata[selectedCoach]['coachmail'] || '');

                    

                    if (coachdata[selectedCoach]['pdf_path']) {
                        $('#existing_pdf').attr('href', coachdata[selectedCoach]['pdf_path']).show();
                        $('#existing_pdf_path').val(coachdata[selectedCoach]['pdf_path']);
                    }else{
                        $('#existing_pdf').hide();
                        $('#existing_pdf_path').val('');
                    }

                   
                    if (coachdata[selectedCoach]['image_path']) {
                        $('#existing_image').attr('src', coachdata[selectedCoach]['image_path']).show();
                        $('#existing_image_path').val(coachdata[selectedCoach]['image_path']);
                    } else {
                        $('#existing_image').hide();
                        $('#existing_image_path').val('');
                    }



                } 
                
              
            });

            // Trigger change to set the initial state if there's already a selected value
            $('#coach').trigger('change');
        @endif
  
     });


    </script>
    
    
    <script>
        document.getElementById('pdf_path').addEventListener('change', function(event) {
            var fileName = event.target.files[0]?.name || "Choose PDF File";
            document.querySelector('.custom-file-label').textContent = fileName;

            // Display the existing PDF link if a file is chosen
            if (fileName !== "Choose PDF file") {
                var existingPdfLink = document.getElementById('existing_pdf');
                existingPdfLink.style.display = 'inline-block';
                existingPdfLink.href = URL.createObjectURL(event.target.files[0]);
            }
        });

        document.getElementById('image_upload').addEventListener('change', function(event) {
            var fileName = event.target.files[0]?.name || "Choose Image File";
            document.querySelector('.custom-file-label2').textContent = fileName;
        });
    </script>
    

    


</body>

</html>
