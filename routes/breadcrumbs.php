<?php

// Home
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

Breadcrumbs::for('brands', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Brands', route('admin.brand.index'));
});
Breadcrumbs::for('add-brand', function ($trail) {
	$trail->parent('brands');
    $trail->push('Add Brand', route('admin.brand.add'));
});
Breadcrumbs::for('edit-brand', function ($trail,$id) {
	$trail->parent('brands');
    $trail->push('Edit Brand', route('admin.brand.edit',$id));
});

Breadcrumbs::for('products', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Products', route('admin.product.index'));
});
Breadcrumbs::for('add-product', function ($trail) {
	$trail->parent('products');
    $trail->push('Add Product', route('admin.product.create'));
});
Breadcrumbs::for('edit-product', function ($trail,$id) {
	$trail->parent('products');
    $trail->push('Edit Product', route('admin.product.edit',$id));
});

Breadcrumbs::for('re-products', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Release Products', route('admin.release_product.index'));
});
Breadcrumbs::for('re-product-add', function ($trail) {
	$trail->parent('re-products');
    $trail->push('Add Release Product', route('admin.release_product.create'));
});
Breadcrumbs::for('re-product-edit', function ($trail,$id) {
	$trail->parent('re-products');
    $trail->push('Edit Release Product', route('admin.release_product.edit',$id));
});

Breadcrumbs::for('users', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Users', route('admin.user.index'));
});
Breadcrumbs::for('u-profile', function ($trail,$id) {
	$trail->parent('users');
    $trail->push('Profile', route('admin.user.profile',$id));
});

Breadcrumbs::for('product-by-size', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Product By Size', route('admin.bids_asks.product_by_size'));
});
Breadcrumbs::for('product-bid-ask', function ($trail,$id) {
	$trail->parent('product-by-size');
    $trail->push('Product Bids & Asks', route('admin.bids_asks.index',$id));
});

Breadcrumbs::for('coupon', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Coupons', route('admin.coupon.index'));
});
Breadcrumbs::for('edit-coupon', function ($trail,$id) {
	$trail->parent('coupon');
    $trail->push('Edit Coupon', route('admin.coupon.edit',$id));
});
Breadcrumbs::for('add-coupon', function ($trail) {
	$trail->parent('coupon');
    $trail->push('Add Coupon', route('admin.coupon.create'));
});