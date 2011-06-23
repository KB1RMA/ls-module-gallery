function fix_zebra()
{
	$('listGallery_Set_Items_reorder_list_body').getChildren().each(function(element, index){
		if (index % 2)
			element.addClass('even');
		else
			element.removeClass('even');
	})
}

function make_sortable()
{
	if ($('listGallery_Set_Items_reorder_list_body'))
	{
		$('listGallery_Set_Items_reorder_list_body').makeListSortable('reorder_onSetOrders', 'sort_order', 'id', 'sort_handle');
		$('listGallery_Set_Items_reorder_list_body').addEvent('dragComplete', fix_zebra);
	}
}

window.addEvent('domready', function(){
	if ($('listGallery_Set_Items_reorder_list_body'))
	{
		$('listGallery_Set_Items_reorder_list_body').addEvent('listUpdated', make_sortable)
		make_sortable();
	}
})