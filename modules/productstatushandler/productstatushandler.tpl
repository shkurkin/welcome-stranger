<script type="text/javascript">
    $(document).ready(function() {ldelim}
        window.open('{$link->getAdminLink('AdminPdf')|escape:'htmlall':'UTF-8'}&submitAction=generateInvoicePDF&id_order={$OrderId}', 'thisWindow', "height=200,width=200");
    {rdelim});
</script>