<!-- Footer -->
<footer class="mt-auto">
	<div class="footer">
		<span class='uppercase'>&copy; 2022 Martech Medical Products</span>
		<nav>
			<a href="mailto:Yeti Themes<info@yetithemes.net>?subject=Support">Support</a>
			<span class="divider">|</span>
			<a href="http://yeti.yetithemes.net/docs" target="_blank">Docs</a>
		</nav>
	</div>
</footer>

</main>

<!-- Scripts -->
<script src="<?php echo  base_url() ?>assets/js/vendor.js"></script>
<script src="<?php echo  base_url() ?>assets/js/script.js"></script>
s
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
	$(document).ready(function() {
		$('#asset-table').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		} );
	} );
</script>


</body>

</html>
