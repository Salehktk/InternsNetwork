<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('adminlte/dist/js/demo.js') }}"></script>


<!-- DataTables -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- New Added -->

<script src="//cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.0.1/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>


<!-- New Added -->


<script>
    $(document).ready(function() {
        $('#showInputBtn').on('click', function() {
            $('#emailInput').toggle();
        });
        $('#example').DataTable();

        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $("#searchfield1").on("input", function() {
            handleSearch();
        });

        $("#searchForm").submit(function(e) {
            e.preventDefault();
            handleSearch();
        });

    });

    function handleSearch() {
        var searchText = $("#searchfield1").val().toLowerCase();
        var noRecordFound = true;

        $("#documentTable tbody tr").each(function() {
            var rowData = $(this).text().toLowerCase();
            var rowVisible = rowData.indexOf(searchText) > -1;
            $(this).toggle(rowVisible);

            if (rowVisible) {
                noRecordFound = false;
            }
        });

        // Show/hide the "No records found" message
        $("#noRecordFound").toggle(noRecordFound);
    }
</script>

<script>
    $(document).ready(function() {

       
    
        $('.js-example-tags').select2({
            maximumSelectionLength: 1,
            allowClear: true
        });

        $('#deadline').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            showOnFocus: false,
            startDate: new Date()
        });

        $('#deadline').focus(function() {
            if (!$('.js-example-tags').select2('isOpen')) {
                $(this).datepicker('show');
            }
        });

        $('.js-example-tags').on('select2:open', function(e) {
            $('#deadline').datepicker('hide');
        });

        $.validator.setDefaults({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

      

    });

    var iti;



    function validateNumberLength(element, maxLength) {
        if (element.value.length > maxLength) {
            element.value = element.value.slice(0, maxLength);
        }
    }

    //// code for auto biography select when coach is selected
    @if (isset($coachBiographyMap))
        const coachBiographyMap = {!! json_encode($coachBiographyMap) !!};

        $('#coach').change(function() {
            const selectedCoach = $(this).val();
            if (selectedCoach && coachBiographyMap[selectedCoach]) {
                $('#Bio').val(coachBiographyMap[selectedCoach]['Bio']);
                $('#coachmail').val(coachBiographyMap[selectedCoach]['coachmail']); // Update the email field
            } else {
                $('#Bio').val('');
                $('#coachmail').val(''); // Clear the email field if no coach is selected
            }
        });
    @endif


    $(document).ready(function() {
    @if (isset($coachBiographyMap))
        const coachBiographyMap = {!! json_encode($coachBiographyMap) !!};

        $('#client').change(function() {
            const selectedCoach = $(this).val();
            if (selectedCoach && coachBiographyMap[selectedCoach]) {
                $('#clientmail').val(coachBiographyMap[selectedCoach]['Primary Email']);
            } else {
                $('#clientmail').val('');
            }
        });
    @endif
});

  
    
</script>

<script type="text/javascript">
    var i = 0;
    
  $("#add").click(function(){
        
        ++i;
        $("#dynamicTable").append('<div class="row"><div class="col-md-7"><div class="form"><input style="margin-top:10px; width: 145%;" type="file" name="resume[]" class="form-control"></div></div><div class="col-md-2"><div class="form"><button type="button" style="margin-top:10px; margin-left: 150px" class="btn btn-danger remove-tr"><i class="fa fa-minus"></i></button></div></div></div>');
    });
    $(document).on('click', '.remove-tr', function(){  
        $(this).closest(".row").remove();
    });  
</script>
        