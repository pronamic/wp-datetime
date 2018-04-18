# WordPress DateTime

## WordPress Filters

### pronamic_datetime_default_format

```php
function prefix_pronamic_datetime_default_format( $format ) {
	return _x( 'D j M Y \a\t H:i', 'default datetime format', 'pronamic-ideal' );
}

add_filter( 'pronamic_datetime_default_format', 'prefix_pronamic_datetime_default_format' );
```

## Inspiration

*	https://github.com/woocommerce/woocommerce/blob/3.3.5/includes/class-wc-datetime.php
*	https://github.com/Rarst/wpdatetime
