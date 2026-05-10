<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('product_image_url')) {
	function product_image_url(?string $image): string
	{
		$image = trim((string) $image);

		if ($image === '') {
			return '';
		}

		if (preg_match('#^https?://#i', $image) || str_starts_with($image, '//')) {
			return $image;
		}

		return base_url('uploads/products/' . ltrim($image, '/'));
	}
}
