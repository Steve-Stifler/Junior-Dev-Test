(function($) {
	$.fn.placeholder_plugin = function(){
		if(placeholderIsSupported()) {
			//браузер поддерживает атрибут "placeholder", не делаем ничего
			return this;
		} else {
			//браузер не поддерживает атрибут "placeholder"
			//эмитируем его работу для каждого элемента с установленным атрибутом
			return this.each(
				function () {
					var placeholder = $(this).attr("placeholder");
					$(this).attr("style", "color: grey;");
					//добавляем в ячейку ввода текст, который эмитирует плейсхолдер
					$(this).val(placeholder);
					//при фокусеровке на элементе (клике на него)
					//в случае, если текст в ячейке - это "плейсхолдер",
					//то очищаем ячейку ввода от "плейсхолдера"
					$(this).focus( 
						function() {
							if ($(this).val() == placeholder) {
								$(this).val('');
								$(this).removeAttr("style");
							}
						}
					);
					//при расфокусе элемента (клике на любую другую часть страницы)
					//и пустой ячейке ввода возвращаем "плейсхолдер"
					$(this).blur(
						function() {
							if ($(this).val() == '') {
								$(this).val(placeholder);
								$(this).attr("style", "color: grey;");
							}
						}
					);
				}
			)
		}
	
		//Проверка, поддерживает ли браузер атрибут "placeholder"
		//Источник: http://stackoverflow.com/questions/8263891/simple-way-to-check-if-placeholder-is-supported
		function placeholderIsSupported() {
			var test = document.createElement('input');
			return ('placeholder' in test);
		}
	}
})(jQuery);

$(document).ready(function(){
	//вызов функции для всех элементов с установленным атрибутом "placeholder"
	$("[placeholder]").placeholder_plugin();
});
