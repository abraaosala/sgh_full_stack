<!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script> -->
<!-- [Page Specific JS] start -->
<script src="<?= asset("js/plugins/apexcharts.min.js", true) ?>"></script>
<script src="<?= asset("js/pages/dashboard-default.js", true) ?>"></script>
<!-- [Page Specific JS] end -->
<!-- Required Js -->
<script src="<?= asset("js/plugins/popper.min.js", true) ?>"></script>
<script src="<?= asset("js/plugins/simplebar.min.js", true) ?>">
</script>
<script src="<?= asset("js/plugins/sweetalert2.all.min.js", true) ?>"></script>

<!-- <script src="<?= asset("js/plugins/bootstrap.min.js", true) ?>"></script> -->
<script src="<?= asset("vendor/bootstrap/js/bootstrap.min.js") ?>"></script>
<script src="<?= asset("js/fonts/custom-font.js") ?>"></script>
<script src=" <?= asset("js/pcoded.js", true) ?>"></script>
<script src="<?= asset("js/plugins/feather.min.js", true) ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Custom Js -->
<script src="<?= asset("js/custom.js") ?>"></script>




<!-- jQuery (necessário para Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function() {
        $('#provincia').select2({
            placeholder: "Selecione uma província",
            allowClear: true,
            width: '100%'
        });
    });
</script>

<script>
    layout_change('light');
</script>




<script>
    change_box_container('false');
</script>



<script>
    layout_rtl_change('false');
</script>


<script>
    preset_change("preset-1");
</script>


<script>
    font_change("Public-Sans");
</script>



</body>
<!-- [Body] end -->

</html>