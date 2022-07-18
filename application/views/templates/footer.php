<!-- Footer -->
<footer class="mt-auto">
    <div class="footer">
        <span class='uppercase'>&copy; 2022 Martech Medical Products</span>
        <!--<nav>
            <a href="mailto:Yeti Themes<info@yetithemes.net>?subject=Support">Support</a>
            <span class="divider">|</span>
            <a href="http://yeti.yetithemes.net/docs" target="_blank">Docs</a>
        </nav>-->
    </div>
</footer>

</main>

<!-- Scripts -->
<script src="<?php echo  base_url() ?>assets/js/vendor.js"></script>
<script src="<?php echo  base_url() ?>assets/js/script.js"></script>

<!-- Datatables -->
<script src="<?php echo  base_url() ?>assets/datatables/DataTables-1.12.0/js/jquery.dataTables.min.js"></script>
<script src="<?php echo  base_url() ?>assets/datatables/Buttons-2.2.3/js/dataTables.buttons.min.js"></script>
<script src="<?php echo  base_url() ?>assets/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="<?php echo  base_url() ?>assets/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="<?php echo  base_url() ?>assets/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="<?php echo  base_url() ?>assets/datatables/Buttons-2.2.3/js/buttons.html5.min.js"></script>
<script src="<?php echo  base_url() ?>assets/datatables/Buttons-2.2.3/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#asset-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>


</body>

</html>