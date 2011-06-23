alter table gallery_set_items add column sort_order int;
update gallery_set_items set sort_order = id;