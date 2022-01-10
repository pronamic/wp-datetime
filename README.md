# WordPress DateTime

## WordPress Filters

### pronamic_datetime_default_format

```php
function prefix_pronamic_datetime_default_format( $format ) {
	return _x( 'D j M Y \a\t H:i', 'default datetime format', 'pronamic-ideal' );
}

add_filter( 'pronamic_datetime_default_format', 'prefix_pronamic_datetime_default_format' );
```

## Note `date_i18n`

It is important to note that `date_i18n()`:

1.	does not have full feature parity with `date()`, not all formats are supported (such as shorthands);
2.	does not accept Unix timestamp (despite documented to), the expected value is “WordPress timestamp” (offset by time zone);
3.	has issues with certain timezone settings, such as numerical ones;
4.	does _nothing_ with `$gmt` argument under normal circumstances;

Any use of this function must be carefully audited for correctness, _especially_ in regards to output of time zones.

Source: https://developer.wordpress.org/reference/functions/date_i18n/#comment-2403

## Inspiration

*	https://github.com/woocommerce/woocommerce/blob/3.3.5/includes/class-wc-datetime.php
*	https://github.com/Rarst/wpdatetime

[![Pronamic - Work with us](https://github.com/pronamic/brand-resources/blob/main/banners/pronamic-work-with-us-leaderboard-728x90%404x.png)](https://www.pronamic.eu/contact/)
