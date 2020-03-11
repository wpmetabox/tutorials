<label for="{{field.id}}_language"><?php esc_html_e( 'Language', 'meta-box-builder' ) ?></label>
<select ng-model="field.language" id="{{field.id}}_language" class="widefat">
	<?php
	$language_code  = 'ar,bg,bn,ca,cs,da,de,el,en,en-AU,en-GB,es,eu,eu,fa,fi,fil,fr,gl,gu,hi,hr,hu,id,it,iw,ja,kn,ko,lt,lv,ml,mr,nl,no,pl,pt,pt-BR,pt-PT,ro,ru,sk,sl,sr,sv,ta,te,th,tl,tr,uk,vi,zh-CN,zh-TW';
	$language_name = 'Arabic,Bulgarian,Bengali,Catalan,Czech,Danish,German,Greek,English,English (Australian),English (Great Britain),Spanish,Basque,Basque,Farsi,Finnish,Filipino,French,Galician,Gujarati,Hindi,Croatian,Hungarian,Indonesian,Italian,Hebrew,Japanese,Kannada,Korean,Lithuanian,Latvian,Malayalam,Marathi,Dutch,Norwegian,Polish,Portuguese,Portuguese (Brazil),Portuguese (Portugal),Romanian,Russian,Slovak,Slovenian,Serbian,Swedish,Tamil,Telugu,Thai,Tagalog,Turkish,Ukrainian,Vietnamese,Chinese (Simplified),Chinese (Traditional)';

	$language_code_item = explode( ',', $language_code );
	$language_name_item = explode( ',', $language_name );
	$language = array_combine( $language_code_item, $language_name_item );
	?>
	<?php foreach ( array_unique( $language ) as $code => $name ) : ?>
		<option value="<?= esc_attr( $code ) ?>"><?= esc_html( $name ) ?></option>
	<?php endforeach ?>
</select>