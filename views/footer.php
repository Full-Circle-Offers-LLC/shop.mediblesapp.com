<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

        $('.js-show-white-label').on('click', function () {
            $('.js-white-label').show("slow");
        });
    });
</script>