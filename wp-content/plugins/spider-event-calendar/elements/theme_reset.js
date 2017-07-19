function reset_theme_1() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('A6BA7D');
    document.getElementById('bg_bottom').color.fromString('FDFCDE');
    document.getElementById('border_color').color.fromString('000000');
    document.getElementById('text_color_month').color.fromString('080808');
    document.getElementById('text_color_week_days').color.fromString('000000');
    document.getElementById('text_color_other_months').color.fromString('6E5959');
    document.getElementById('text_color_this_month_unevented').color.fromString('060D12');
    document.getElementById('text_color_this_month_evented').color.fromString('000000');
    document.getElementById('event_title_color').color.fromString('000000');
    document.getElementById('current_day_border_color').color.fromString('4AFF9E');
    document.getElementById('bg_color_this_month_evented').color.fromString('FF6933');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('E0E0C5');
    document.getElementById('show_event_bgcolor').color.fromString('FDFCDE');
    document.getElementById('cell_border_color').color.fromString('000000');
    document.getElementById('week_days_cell_height').value = '50';
    document.getElementById('arrow_color_month').color.fromString('000000');
    document.getElementById('text_color_sun_days').color.fromString('FF0000');
    document.getElementById('title_color').color.fromString('000000');
    document.getElementById('next_prev_event_bgcolor').color.fromString('CCCCCC');
    document.getElementById('title_font_size').value = '18';
    document.getElementById('title_font').value = 'Courier New';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('000000');
    document.getElementById('date_size').value = '16';
    document.getElementById('date_font').value = 'Courier New';
    document.getElementById('date_style').value = 'bold';
    document.getElementById('popup_width').value = '800';
    document.getElementById('popup_height').value = '600';
    document.getElementById('number_of_shown_evetns').value = '1';
    document.getElementById('sundays_font_size').value = '18';
    document.getElementById('other_days_font_size').value = '12';
    document.getElementById('weekdays_font_size').value = '14';
    document.getElementById('border_width').value = '2';
    document.getElementById('top_height').value = '90';
    document.getElementById('bg_color_other_months').color.fromString('FFFFFF');
    document.getElementById('sundays_bg_color').color.fromString('FDFCDE');
    document.getElementById('weekdays_bg_color').color.fromString('E6E6DE');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('BD848A');
    document.getElementById('border_radius').value = '0';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('A6BA7C');
    document.getElementById('event_bg_color1').color.fromString('FDFCDE');
    document.getElementById('event_bg_color2').color.fromString('FDFCDE');
    document.getElementById('event_num_bg_color1').color.fromString('FDFCDE');
    document.getElementById('event_num_bg_color2').color.fromString('FDFCDE');
    document.getElementById('event_num_color').color.fromString('000000');
    document.getElementById('day_month_font_color').color.fromString('474747');
    document.getElementById('week_font_color').color.fromString('FFFFFF');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('E8E7CC');
    change_width();
  }
}

function reset_theme_2() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '80';
    document.getElementById('bg_top').color.fromString('36A7E9');
    document.getElementById('bg_bottom').color.fromString('FFFFFF');
    document.getElementById('border_color').color.fromString('000000');
    document.getElementById('text_color_month').color.fromString('000000');
    document.getElementById('text_color_week_days').color.fromString('000000');
    document.getElementById('text_color_other_months').color.fromString('525252');
    document.getElementById('text_color_this_month_unevented').color.fromString('000000');
    document.getElementById('text_color_this_month_evented').color.fromString('FFFFFF');
    document.getElementById('event_title_color').color.fromString('FFFFFF');
    document.getElementById('current_day_border_color').color.fromString('36A7E9');
    document.getElementById('bg_color_this_month_evented').color.fromString('FFA142');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('FFFFFF');
    document.getElementById('show_event_bgcolor').color.fromString('36A7E9');
    document.getElementById('cell_border_color').color.fromString('000000');
    document.getElementById('week_days_cell_height').value = '40';
    document.getElementById('arrow_color_month').color.fromString('000000');
    document.getElementById('text_color_sun_days').color.fromString('36A7E9');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('FFA142');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('FFFFFF');
    document.getElementById('date_size').value = '16';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'bold';
    document.getElementById('popup_width').value = '800';
    document.getElementById('popup_height').value = '600';
    document.getElementById('number_of_shown_evetns').value = '1';
    document.getElementById('sundays_font_size').value = '14';
    document.getElementById('other_days_font_size').value = '12';
    document.getElementById('weekdays_font_size').value = '14';
    document.getElementById('border_width').value = '4';
    document.getElementById('top_height').value = '80';
    document.getElementById('bg_color_other_months').color.fromString('FFFFFF');
    document.getElementById('sundays_bg_color').color.fromString('FFFFFF');
    document.getElementById('weekdays_bg_color').color.fromString('FFFFFF');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('FFFFFF');
    document.getElementById('border_radius').value = '0';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('FFA041');
    document.getElementById('event_bg_color1').color.fromString('FFFFFF');
    document.getElementById('event_bg_color2').color.fromString('FFFFFF');
    document.getElementById('event_num_bg_color1').color.fromString('FFFFFF');
    document.getElementById('event_num_bg_color2').color.fromString('FFFFFF');
    document.getElementById('event_num_color').color.fromString('000000');
    document.getElementById('day_month_font_color').color.fromString('6E6E6E');
    document.getElementById('week_font_color').color.fromString('FFFFFF');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('FFA142');
    change_width();
  }
}

function reset_theme_3() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('00004F');
    document.getElementById('bg_bottom').color.fromString('5BCAFF');
    document.getElementById('border_color').color.fromString('000000');
    document.getElementById('text_color_month').color.fromString('D1D4F5');
    document.getElementById('text_color_week_days').color.fromString('FFFFFF');
    document.getElementById('text_color_other_months').color.fromString('E6E6E6');
    document.getElementById('text_color_this_month_unevented').color.fromString('000000');
    document.getElementById('text_color_this_month_evented').color.fromString('FFFFFF');
    document.getElementById('event_title_color').color.fromString('FFFFFF');
    document.getElementById('current_day_border_color').color.fromString('FFFFFF');
    document.getElementById('bg_color_this_month_evented').color.fromString('00004F');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('FFFFFF');
    document.getElementById('show_event_bgcolor').color.fromString('009EEB');
    document.getElementById('cell_border_color').color.fromString('000000');
    document.getElementById('week_days_cell_height').value = '30';
    document.getElementById('arrow_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_sun_days').color.fromString('000000');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('00004F');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('FFFFFF');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '600';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '1';
    document.getElementById('sundays_font_size').value = '18';
    document.getElementById('other_days_font_size').value = '14';
    document.getElementById('weekdays_font_size').value = '14';
    document.getElementById('border_width').value = '2';
    document.getElementById('top_height').value = '120';
    document.getElementById('bg_color_other_months').color.fromString('C0C0C0');
    document.getElementById('sundays_bg_color').color.fromString('8ADAFF');
    document.getElementById('weekdays_bg_color').color.fromString('000000');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('000000');
    document.getElementById('border_radius').value = '';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('5BCAFF');
    document.getElementById('event_bg_color1').color.fromString('FFFFFF');
    document.getElementById('event_bg_color2').color.fromString('FFFFFF');
    document.getElementById('event_num_bg_color1').color.fromString('FFFFFF');
    document.getElementById('event_num_bg_color2').color.fromString('FFFFFF');
    document.getElementById('event_num_color').color.fromString('000000');
    document.getElementById('day_month_font_color').color.fromString('FFFFFF');
    document.getElementById('week_font_color').color.fromString('FFFFFF');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('5BCAFF');
    change_width();
  }
}

function reset_theme_4() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('2A2829');
    document.getElementById('bg_bottom').color.fromString('323232');
    document.getElementById('border_color').color.fromString('000000');
    document.getElementById('text_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_week_days').color.fromString('FFFFFF');
    document.getElementById('text_color_other_months').color.fromString('FFFFFF');
    document.getElementById('text_color_this_month_unevented').color.fromString('FFFFFF');
    document.getElementById('text_color_this_month_evented').color.fromString('000000');
    document.getElementById('event_title_color').color.fromString('000000');
    document.getElementById('current_day_border_color').color.fromString('FFFFFF');
    document.getElementById('bg_color_this_month_evented').color.fromString('F0F0F0');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('C7C7C7');
    document.getElementById('show_event_bgcolor').color.fromString('969696');
    document.getElementById('cell_border_color').color.fromString('000000');
    document.getElementById('week_days_cell_height').value = '35';
    document.getElementById('arrow_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_sun_days').color.fromString('FFFFFF');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('323232');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('FFFFFF');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '600';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '1';
    document.getElementById('sundays_font_size').value = '16';
    document.getElementById('other_days_font_size').value = '12';
    document.getElementById('weekdays_font_size').value = '14';
    document.getElementById('border_width').value = '2';
    document.getElementById('top_height').value = '90';
    document.getElementById('bg_color_other_months').color.fromString('282828');
    document.getElementById('sundays_bg_color').color.fromString('323232');
    document.getElementById('weekdays_bg_color').color.fromString('969696');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('969696');
    document.getElementById('border_radius').value = '8';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('969696');
    document.getElementById('event_bg_color1').color.fromString('323232');
    document.getElementById('event_bg_color2').color.fromString('323232');
    document.getElementById('event_num_bg_color1').color.fromString('323232');
    document.getElementById('event_num_bg_color2').color.fromString('323232');
    document.getElementById('event_num_color').color.fromString('FFFFFF');
    document.getElementById('day_month_font_color').color.fromString('FFFFFF');
    document.getElementById('week_font_color').color.fromString('FFFFFF');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('969696');
    change_width();
  }
}
function reset_theme_5() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('9A0000');
    document.getElementById('bg_bottom').color.fromString('CDCC96');
    document.getElementById('border_color').color.fromString('E6E6E4');
    document.getElementById('text_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_week_days').color.fromString('000000');
    document.getElementById('text_color_other_months').color.fromString('525252');
    document.getElementById('text_color_this_month_unevented').color.fromString('000000');
    document.getElementById('text_color_this_month_evented').color.fromString('FFFFFF');
    document.getElementById('event_title_color').color.fromString('FFFFFF');
    document.getElementById('current_day_border_color').color.fromString('9A0000');
    document.getElementById('bg_color_this_month_evented').color.fromString('9A0000');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('DEDDB5');
    document.getElementById('show_event_bgcolor').color.fromString('FFFED0');
    document.getElementById('cell_border_color').color.fromString('FFFFFF');
    document.getElementById('week_days_cell_height').value = '60';
    document.getElementById('arrow_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_sun_days').color.fromString('000000');
    document.getElementById('title_color').color.fromString('000000');
    document.getElementById('next_prev_event_bgcolor').color.fromString('9A0000');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('000000');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '600';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '1';
    document.getElementById('sundays_font_size').value = '18';
    document.getElementById('other_days_font_size').value = '';
    document.getElementById('weekdays_font_size').value = '14';
    document.getElementById('border_width').value = '18';
    document.getElementById('top_height').value = '100';
    document.getElementById('bg_color_other_months').color.fromString('E4E7CC');
    document.getElementById('sundays_bg_color').color.fromString('CDCC96');
    document.getElementById('weekdays_bg_color').color.fromString('FFFED0');
    document.getElementById('week_start_day').value = 'mo';
    document.getElementById('weekday_sunday_bg_color').color.fromString('FFFED0');
    document.getElementById('border_radius').value = '6';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('E4E7CC');
    document.getElementById('event_bg_color1').color.fromString('CECD97');
    document.getElementById('event_bg_color2').color.fromString('CECD97');
    document.getElementById('event_num_bg_color1').color.fromString('CECD97');
    document.getElementById('event_num_bg_color2').color.fromString('CECD97');
    document.getElementById('event_num_color').color.fromString('000000');
    document.getElementById('day_month_font_color').color.fromString('8F8F8F');
    document.getElementById('week_font_color').color.fromString('000000');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('CDCC96');
    change_width();
  }
}

function reset_theme_6() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('FCF7D9');
    document.getElementById('bg_bottom').color.fromString('FFFFFF');
    document.getElementById('border_color').color.fromString('3DBCEB');
    document.getElementById('text_color_month').color.fromString('9A0000');
    document.getElementById('text_color_week_days').color.fromString('FFFFFF');
    document.getElementById('text_color_other_months').color.fromString('C7C7C7');
    document.getElementById('text_color_this_month_unevented').color.fromString('1374C3');
    document.getElementById('text_color_this_month_evented').color.fromString('000000');
    document.getElementById('event_title_color').color.fromString('000000');
    document.getElementById('current_day_border_color').color.fromString('9A0000');
    document.getElementById('bg_color_this_month_evented').color.fromString('FCF7D9');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('E0E0E0');
    document.getElementById('show_event_bgcolor').color.fromString('FCF7D9');
    document.getElementById('cell_border_color').color.fromString('1374C3');
    document.getElementById('week_days_cell_height').value = '20';
    document.getElementById('arrow_color_month').color.fromString('9A0000');
    document.getElementById('text_color_sun_days').color.fromString('013A7D');
    document.getElementById('title_color').color.fromString('000000');
    document.getElementById('next_prev_event_bgcolor').color.fromString('21B5FF');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('000000');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'bold';
    document.getElementById('popup_width').value = '600';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '1';
    document.getElementById('sundays_font_size').value = '16';
    document.getElementById('other_days_font_size').value = '12';
    document.getElementById('weekdays_font_size').value = '14';
    document.getElementById('border_width').value = '12';
    document.getElementById('top_height').value = '93';
    document.getElementById('bg_color_other_months').color.fromString('FFFFFF');
    document.getElementById('sundays_bg_color').color.fromString('FFFFFF');
    document.getElementById('weekdays_bg_color').color.fromString('013A7D');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('1374C3');
    document.getElementById('border_radius').value = '6';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('3CBBEB');
    document.getElementById('event_bg_color1').color.fromString('FFFFFF');
    document.getElementById('event_bg_color2').color.fromString('FFFFFF');
    document.getElementById('event_num_bg_color1').color.fromString('FCF7D9');
    document.getElementById('event_num_bg_color2').color.fromString('FFFFFF');
    document.getElementById('event_num_color').color.fromString('970000');
    document.getElementById('day_month_font_color').color.fromString('FBE6E6');
    document.getElementById('week_font_color').color.fromString('FFFFFF');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('3DBCEB');
    change_width();
  }
}

function reset_theme_7() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('598923');
    document.getElementById('bg_bottom').color.fromString('F0F0E6');
    document.getElementById('border_color').color.fromString('D78B29');
    document.getElementById('text_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_week_days').color.fromString('000000');
    document.getElementById('text_color_other_months').color.fromString('A6A6A6');
    document.getElementById('text_color_this_month_unevented').color.fromString('5C5C5C');
    document.getElementById('text_color_this_month_evented').color.fromString('FFFFFF');
    document.getElementById('event_title_color').color.fromString('FFFFFF');
    document.getElementById('current_day_border_color').color.fromString('000000');
    document.getElementById('bg_color_this_month_evented').color.fromString('D78B29');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('D78B29');
    document.getElementById('show_event_bgcolor').color.fromString('FFB061');
    document.getElementById('cell_border_color').color.fromString('363636');
    document.getElementById('week_days_cell_height').value = '30';
    document.getElementById('arrow_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_sun_days').color.fromString('000000');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('DDDCC8');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = 'Courier New';
    document.getElementById('title_style').value = 'bold';
    document.getElementById('date_color').color.fromString('000000');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '600';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '1';
    document.getElementById('sundays_font_size').value = '16';
    document.getElementById('other_days_font_size').value = '12';
    document.getElementById('weekdays_font_size').value = '14';
    document.getElementById('border_width').value = '12';
    document.getElementById('top_height').value = '100';
    document.getElementById('bg_color_other_months').color.fromString('DDDCC8');
    document.getElementById('sundays_bg_color').color.fromString('F0F0E6');
    document.getElementById('weekdays_bg_color').color.fromString('D78B29');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('D78B29');
    document.getElementById('border_radius').value = '6';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('588922');
    document.getElementById('event_bg_color1').color.fromString('F0F0E6');
    document.getElementById('event_bg_color2').color.fromString('F0F0E6');
    document.getElementById('event_num_bg_color1').color.fromString('F0F0E6');
    document.getElementById('event_num_bg_color2').color.fromString('F0F0E6');
    document.getElementById('event_num_color').color.fromString('000000');
    document.getElementById('day_month_font_color').color.fromString('FFFFFF');
    document.getElementById('week_font_color').color.fromString('FFFFFF');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('D78B29');
    change_width();
  }
}

function reset_theme_8() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('009898');
    document.getElementById('bg_bottom').color.fromString('FDFDCC');
    document.getElementById('border_color').color.fromString('FDFDCC');
    document.getElementById('text_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_week_days').color.fromString('000000');
    document.getElementById('text_color_other_months').color.fromString('8C8C8C');
    document.getElementById('text_color_this_month_unevented').color.fromString('383838');
    document.getElementById('text_color_this_month_evented').color.fromString('383838');
    document.getElementById('event_title_color').color.fromString('FFFFFF');
    document.getElementById('current_day_border_color').color.fromString('000000');
    document.getElementById('bg_color_this_month_evented').color.fromString('FE7C00');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('FEAC30');
    document.getElementById('show_event_bgcolor').color.fromString('FE7C00');
    document.getElementById('cell_border_color').color.fromString('4D4D4D');
    document.getElementById('week_days_cell_height').value = '30';
    document.getElementById('arrow_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_sun_days').color.fromString('000000');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('FDFDE8');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('FFFFFF');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '600';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '1';
    document.getElementById('sundays_font_size').value = '16';
    document.getElementById('other_days_font_size').value = '12';
    document.getElementById('weekdays_font_size').value = '14';
    document.getElementById('border_width').value = '14';
    document.getElementById('top_height').value = '90';
    document.getElementById('bg_color_other_months').color.fromString('FDFDE8');
    document.getElementById('sundays_bg_color').color.fromString('BACBDC');
    document.getElementById('weekdays_bg_color').color.fromString('9865FE');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('9865FE');
    document.getElementById('border_radius').value = '2';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('9765FD');
    document.getElementById('event_bg_color1').color.fromString('FDFCCC');
    document.getElementById('event_bg_color2').color.fromString('FDFCCC');
    document.getElementById('event_num_bg_color1').color.fromString('FDFCCC');
    document.getElementById('event_num_bg_color2').color.fromString('FDFCCC');
    document.getElementById('event_num_color').color.fromString('000000');
    document.getElementById('day_month_font_color').color.fromString('FFFFFF');
    document.getElementById('week_font_color').color.fromString('FFFFFF');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('FDFDCC');
    change_width();
  }
}

function reset_theme_9() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('346699');
    document.getElementById('bg_bottom').color.fromString('E3F9F9');
    document.getElementById('border_color').color.fromString('346699');
    document.getElementById('text_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_week_days').color.fromString('FFFFFF');
    document.getElementById('text_color_other_months').color.fromString('FFFFFF');
    document.getElementById('text_color_this_month_unevented').color.fromString('2410EE');
    document.getElementById('text_color_this_month_evented').color.fromString('000000');
    document.getElementById('event_title_color').color.fromString('000000');
    document.getElementById('current_day_border_color').color.fromString('346699');
    document.getElementById('bg_color_this_month_evented').color.fromString('FFCC33');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('E3B62D');
    document.getElementById('show_event_bgcolor').color.fromString('FFCC33');
    document.getElementById('cell_border_color').color.fromString('6B6B6B');
    document.getElementById('week_days_cell_height').value = '25';
    document.getElementById('arrow_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_sun_days').color.fromString('2410EE');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('346699');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('000000');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '600';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '1';
    document.getElementById('sundays_font_size').value = '18';
    document.getElementById('other_days_font_size').value = '14';
    document.getElementById('weekdays_font_size').value = '14';
    document.getElementById('border_width').value = '10';
    document.getElementById('top_height').value = '100';
    document.getElementById('bg_color_other_months').color.fromString('CCCCCC');
    document.getElementById('sundays_bg_color').color.fromString('CDDDFF');
    document.getElementById('weekdays_bg_color').color.fromString('68676D');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('68676D');
    document.getElementById('border_radius').value = '4';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('E3F8FA');
    document.getElementById('event_bg_color1').color.fromString('CCCCCC');
    document.getElementById('event_bg_color2').color.fromString('CCCCCC');
    document.getElementById('event_num_bg_color1').color.fromString('CCCCCC');
    document.getElementById('event_num_bg_color2').color.fromString('CCCCCC');
    document.getElementById('event_num_color').color.fromString('000000');
    document.getElementById('day_month_font_color').color.fromString('726ED6');
    document.getElementById('week_font_color').color.fromString('726ED6');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('CDDDFF');
    change_width();
  }
}

function reset_theme_10() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('C0EFC0');
    document.getElementById('bg_bottom').color.fromString('E3F9F9');
    document.getElementById('border_color').color.fromString('ABCEA8');
    document.getElementById('text_color_month').color.fromString('58A42B');
    document.getElementById('text_color_week_days').color.fromString('000000');
    document.getElementById('text_color_other_months').color.fromString('B0B0B0');
    document.getElementById('text_color_this_month_unevented').color.fromString('383838');
    document.getElementById('text_color_this_month_evented').color.fromString('383838');
    document.getElementById('event_title_color').color.fromString('383838');
    document.getElementById('current_day_border_color').color.fromString('58A42B');
    document.getElementById('bg_color_this_month_evented').color.fromString('C0EFC0');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('AED9AE');
    document.getElementById('show_event_bgcolor').color.fromString('C0EFC0');
    document.getElementById('cell_border_color').color.fromString('B1B1B0');
    document.getElementById('week_days_cell_height').value = '25';
    document.getElementById('arrow_color_month').color.fromString('58A42B');
    document.getElementById('text_color_sun_days').color.fromString('FF7C5C');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('58A42B');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('262626');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '600';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '1';
    document.getElementById('sundays_font_size').value = '16';
    document.getElementById('other_days_font_size').value = '12';
    document.getElementById('weekdays_font_size').value = '12';
    document.getElementById('border_width').value = '8';
    document.getElementById('top_height').value = '40';
    document.getElementById('bg_color_other_months').color.fromString('E1DDE9');
    document.getElementById('sundays_bg_color').color.fromString('FFFFFF');
    document.getElementById('weekdays_bg_color').color.fromString('FFFFFF');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('FFFFFF');
    document.getElementById('border_radius').value = '2';
    document.getElementById('month_font_size').value = '20';
    document.getElementById('arrow_size').value = '20';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('DFDDE7');
    document.getElementById('event_bg_color1').color.fromString('E4F9FA');
    document.getElementById('event_bg_color2').color.fromString('E4F9FA');
    document.getElementById('event_num_bg_color1').color.fromString('FFFFFF');
    document.getElementById('event_num_bg_color2').color.fromString('FFFFFF');
    document.getElementById('event_num_color').color.fromString('000000');
    document.getElementById('day_month_font_color').color.fromString('7DAC84');
    document.getElementById('week_font_color').color.fromString('7DAC84');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('E3F9F9');
    change_width();
  }
}

function reset_theme_11() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('E7C892');
    document.getElementById('bg_bottom').color.fromString('7E5F43');
    document.getElementById('border_color').color.fromString('FFC219');
    document.getElementById('text_color_month').color.fromString('404040');
    document.getElementById('text_color_week_days').color.fromString('404040');
    document.getElementById('text_color_other_months').color.fromString('FFFFFF');
    document.getElementById('text_color_this_month_unevented').color.fromString('FFFFFF');
    document.getElementById('text_color_this_month_evented').color.fromString('404040');
    document.getElementById('event_title_color').color.fromString('404040');
    document.getElementById('current_day_border_color').color.fromString('FFFFFF');
    document.getElementById('bg_color_this_month_evented').color.fromString('FFC219');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('B3875F');
    document.getElementById('show_event_bgcolor').color.fromString('7E5F43');
    document.getElementById('cell_border_color').color.fromString('000000');
    document.getElementById('week_days_cell_height').value = '30';
    document.getElementById('arrow_color_month').color.fromString('404040');
    document.getElementById('text_color_sun_days').color.fromString('FFFFFF');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('FFC219');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('FFFFFF');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '800';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '2';
    document.getElementById('sundays_font_size').value = '18';
    document.getElementById('other_days_font_size').value = '12';
    document.getElementById('weekdays_font_size').value = '14';
    document.getElementById('border_width').value = '10';
    document.getElementById('top_height').value = '100';
    document.getElementById('bg_color_other_months').color.fromString('523F30');
    document.getElementById('sundays_bg_color').color.fromString('7E5F43');
    document.getElementById('weekdays_bg_color').color.fromString('FFC219');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('FFC219');
    document.getElementById('border_radius').value = '6';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('FFC11A');
    document.getElementById('event_bg_color1').color.fromString('7E5F43');
    document.getElementById('event_bg_color2').color.fromString('7E5F43');
    document.getElementById('event_num_bg_color1').color.fromString('7E5F43');
    document.getElementById('event_num_bg_color2').color.fromString('7E5F43');
    document.getElementById('event_num_color').color.fromString('FFFFFF');
    document.getElementById('day_month_font_color').color.fromString('4F3A11');
    document.getElementById('week_font_color').color.fromString('4F3A11');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '15';
    document.getElementById('event_table_height').value = '25';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '13';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('views_tabs_bg_color').color.fromString('FFC219');
    change_width();
  }
}

function reset_theme_12() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '65';
    document.getElementById('bg_top').color.fromString('520017');
    document.getElementById('bg_bottom').color.fromString('E1E1E1');
    document.getElementById('border_color').color.fromString('FFFFFF');
    document.getElementById('text_color_month').color.fromString('FEFCFC');
    document.getElementById('text_color_week_days').color.fromString('2A674D');
    document.getElementById('text_color_other_months').color.fromString('817F7F');
    document.getElementById('text_color_this_month_unevented').color.fromString('817F7F');
    document.getElementById('text_color_this_month_evented').color.fromString('817F7F');
    document.getElementById('event_title_color').color.fromString('292929');
    document.getElementById('current_day_border_color').color.fromString('520017');
    document.getElementById('bg_color_this_month_evented').color.fromString('B69DA4');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('B69DA4');
    document.getElementById('show_event_bgcolor').color.fromString('C5B1B6');
    document.getElementById('cell_border_color').color.fromString('B1B1B0');
    document.getElementById('week_days_cell_height').value = '50';
    document.getElementById('arrow_color_month').color.fromString('D0D0D0');
    document.getElementById('text_color_sun_days').color.fromString('817F7F');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('997783');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('262626');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '800';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '2';
    document.getElementById('sundays_font_size').value = '23';
    document.getElementById('other_days_font_size').value = '23';
    document.getElementById('weekdays_font_size').value = '20';
    document.getElementById('border_width').value = '0';
    document.getElementById('top_height').value = '100';
    document.getElementById('bg_color_other_months').color.fromString('E1E1E1');
    document.getElementById('sundays_bg_color').color.fromString('E1E1E1');
    document.getElementById('weekdays_bg_color').color.fromString('E1E1E1');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('BBBBBB');
    document.getElementById('border_radius').value = '0';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('D6D5D5');
    document.getElementById('event_bg_color1').color.fromString('E1E1E1');
    document.getElementById('event_bg_color2').color.fromString('E1E1E1');
    document.getElementById('event_num_bg_color1').color.fromString('450013');
    document.getElementById('event_num_bg_color2').color.fromString('5A011A');
    document.getElementById('event_num_color').color.fromString('FFFFFF');
    document.getElementById('day_month_font_color').color.fromString('747474');
    document.getElementById('week_font_color').color.fromString('400012');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '13';
    document.getElementById('event_table_height').value = '30';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '12';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('ev_title_bg_color').color.fromString('C5B1B6');
    document.getElementById('views_tabs_bg_color').color.fromString('01799C');
    change_width();
  }
}

function reset_theme_13() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('005478');
    document.getElementById('bg_bottom').color.fromString('E1E1E1');
    document.getElementById('border_color').color.fromString('005478');
    document.getElementById('text_color_month').color.fromString('F9F2F4');
    document.getElementById('text_color_week_days').color.fromString('005D78');
    document.getElementById('text_color_other_months').color.fromString('B0B0B0');
    document.getElementById('text_color_this_month_unevented').color.fromString('6A6A6A');
    document.getElementById('text_color_this_month_evented').color.fromString('6A6A6A');
    document.getElementById('event_title_color').color.fromString('236283');
    document.getElementById('current_day_border_color').color.fromString('005478');
    document.getElementById('bg_color_this_month_evented').color.fromString('B4C5CC');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('97A0A6');
    document.getElementById('show_event_bgcolor').color.fromString('B4C5CC');
    document.getElementById('cell_border_color').color.fromString('A9A9A9');
    document.getElementById('week_days_cell_height').value = '50';
    document.getElementById('arrow_color_month').color.fromString('CCD1D2');
    document.getElementById('text_color_sun_days').color.fromString('6A6A6A');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('00608A');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('262626');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '800';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '2';
    document.getElementById('sundays_font_size').value = '25';
    document.getElementById('other_days_font_size').value = '25';
    document.getElementById('weekdays_font_size').value = '25';
    document.getElementById('border_width').value = '0';
    document.getElementById('top_height').value = '100';
    document.getElementById('bg_color_other_months').color.fromString('E1E1E1');
    document.getElementById('sundays_bg_color').color.fromString('E1E1E1');
    document.getElementById('weekdays_bg_color').color.fromString('D6D6D6');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('B5B5B5');
    document.getElementById('border_radius').value = '0';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('D6D4D5');
    document.getElementById('event_bg_color1').color.fromString('E1E1E1');
    document.getElementById('event_bg_color2').color.fromString('DEDCDD');
    document.getElementById('event_num_bg_color1').color.fromString('005478');
    document.getElementById('event_num_bg_color2').color.fromString('006E91');
    document.getElementById('event_num_color').color.fromString('FFFFFF');
    document.getElementById('day_month_font_color').color.fromString('737373');
    document.getElementById('week_font_color').color.fromString('005476');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '13';
    document.getElementById('event_table_height').value = '30';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '12';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('ev_title_bg_color').color.fromString('C3D0D6');
    document.getElementById('views_tabs_bg_color').color.fromString('860126');
    change_width();
  }
}

function reset_theme_14() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('00512F');
    document.getElementById('bg_bottom').color.fromString('E1E1E1');
    document.getElementById('border_color').color.fromString('005478');
    document.getElementById('text_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_week_days').color.fromString('175E41');
    document.getElementById('text_color_other_months').color.fromString('B0B0B0');
    document.getElementById('text_color_this_month_unevented').color.fromString('9A9898');
    document.getElementById('text_color_this_month_evented').color.fromString('9A9898');
    document.getElementById('event_title_color').color.fromString('383838');
    document.getElementById('current_day_border_color').color.fromString('00502F');
    document.getElementById('bg_color_this_month_evented').color.fromString('9DB5AB');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('9DB5AB');
    document.getElementById('show_event_bgcolor').color.fromString('B1C4BC');
    document.getElementById('cell_border_color').color.fromString('B1B1B0');
    document.getElementById('week_days_cell_height').value = '50';
    document.getElementById('arrow_color_month').color.fromString('CFD2CF');
    document.getElementById('text_color_sun_days').color.fromString('9A9898');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('175E41');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('FFFFFF');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '800';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '2';
    document.getElementById('sundays_font_size').value = '25';
    document.getElementById('other_days_font_size').value = '25';
    document.getElementById('weekdays_font_size').value = '20';
    document.getElementById('border_width').value = '0';
    document.getElementById('top_height').value = '100';
    document.getElementById('bg_color_other_months').color.fromString('E1E1E1');
    document.getElementById('sundays_bg_color').color.fromString('E1E1E1');
    document.getElementById('weekdays_bg_color').color.fromString('E0E0E0');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('BBBBBB');
    document.getElementById('border_radius').value = '0';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('D6D5D5');
    document.getElementById('event_bg_color1').color.fromString('E1E1E1');
    document.getElementById('event_bg_color2').color.fromString('DEDDDD');
    document.getElementById('event_num_bg_color1').color.fromString('003C23');
    document.getElementById('event_num_bg_color2').color.fromString('00502F');
    document.getElementById('event_num_color').color.fromString('FFFFFF');
    document.getElementById('day_month_font_color').color.fromString('747474');
    document.getElementById('week_font_color').color.fromString('003D24');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '13';
    document.getElementById('event_table_height').value = '30';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '12';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('ev_title_bg_color').color.fromString('B1C4BC');
    document.getElementById('views_tabs_bg_color').color.fromString('00882A');
    change_width();
  }
}

function reset_theme_15() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('D57E01');
    document.getElementById('bg_bottom').color.fromString('E1E1E1');
    document.getElementById('border_color').color.fromString('005478');
    document.getElementById('text_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_week_days').color.fromString('015130');
    document.getElementById('text_color_other_months').color.fromString('B0B0B0');
    document.getElementById('text_color_this_month_unevented').color.fromString('7C7A7A');
    document.getElementById('text_color_this_month_evented').color.fromString('7C7A7A');
    document.getElementById('event_title_color').color.fromString('383838');
    document.getElementById('current_day_border_color').color.fromString('D57E01');
    document.getElementById('bg_color_this_month_evented').color.fromString('DDC39D');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('E4CFB1');
    document.getElementById('show_event_bgcolor').color.fromString('DDC39D');
    document.getElementById('cell_border_color').color.fromString('B1B1B0');
    document.getElementById('week_days_cell_height').value = '50';
    document.getElementById('arrow_color_month').color.fromString('E1E2D9');
    document.getElementById('text_color_sun_days').color.fromString('7C7A7A');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('D37D00');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('FFFFFF');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '800';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '2';
    document.getElementById('sundays_font_size').value = '25';
    document.getElementById('other_days_font_size').value = '25';
    document.getElementById('weekdays_font_size').value = '20';
    document.getElementById('border_width').value = '0';
    document.getElementById('top_height').value = '100';
    document.getElementById('bg_color_other_months').color.fromString('E1DDE9');
    document.getElementById('sundays_bg_color').color.fromString('E1E1E1');
    document.getElementById('weekdays_bg_color').color.fromString('E1E1E1');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('BBBBBB');
    document.getElementById('border_radius').value = '0';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('D6D5D5');
    document.getElementById('event_bg_color1').color.fromString('E1E1E1');
    document.getElementById('event_bg_color2').color.fromString('DEDDDD');
    document.getElementById('event_num_bg_color1').color.fromString('AB6501');
    document.getElementById('event_num_bg_color2').color.fromString('D57E01');
    document.getElementById('event_num_color').color.fromString('FFFFFF');
    document.getElementById('day_month_font_color').color.fromString('838383');
    document.getElementById('week_font_color').color.fromString('A26001');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '13';
    document.getElementById('event_table_height').value = '30';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '12';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('ev_title_bg_color').color.fromString('E4CFB1');
    document.getElementById('views_tabs_bg_color').color.fromString('E0AD01');
    change_width();
  }
}

function reset_theme_16() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('FEA2EC');
    document.getElementById('bg_bottom').color.fromString('E1E1E1');
    document.getElementById('border_color').color.fromString('005478');
    document.getElementById('text_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_week_days').color.fromString('00502F');
    document.getElementById('text_color_other_months').color.fromString('B0B0B0');
    document.getElementById('text_color_this_month_unevented').color.fromString('817F7F');
    document.getElementById('text_color_this_month_evented').color.fromString('817F7F');
    document.getElementById('event_title_color').color.fromString('383838');
    document.getElementById('current_day_border_color').color.fromString('FEA2EC');
    document.getElementById('bg_color_this_month_evented').color.fromString('EACEE4');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('EED8E9');
    document.getElementById('show_event_bgcolor').color.fromString('EACEE4');
    document.getElementById('cell_border_color').color.fromString('B1B1B0');
    document.getElementById('week_days_cell_height').value = '50';
    document.getElementById('arrow_color_month').color.fromString('D1D1D1');
    document.getElementById('text_color_sun_days').color.fromString('817F7F');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('FA9FE8');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('FFFFFF');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '800';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '2';
    document.getElementById('sundays_font_size').value = '25';
    document.getElementById('other_days_font_size').value = '25';
    document.getElementById('weekdays_font_size').value = '20';
    document.getElementById('border_width').value = '0';
    document.getElementById('top_height').value = '100';
    document.getElementById('bg_color_other_months').color.fromString('E1E1E1');
    document.getElementById('sundays_bg_color').color.fromString('E1E1E1');
    document.getElementById('weekdays_bg_color').color.fromString('D6D6D6');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('B5B5B5');
    document.getElementById('border_radius').value = '0';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('D6D5D5');
    document.getElementById('event_bg_color1').color.fromString('E1E1E1');
    document.getElementById('event_bg_color2').color.fromString('DEDDDD');
    document.getElementById('event_num_bg_color1').color.fromString('C17BB4');
    document.getElementById('event_num_bg_color2').color.fromString('FCA0EA');
    document.getElementById('event_num_color').color.fromString('FFFFFF');
    document.getElementById('day_month_font_color').color.fromString('999898');
    document.getElementById('week_font_color').color.fromString('BD78B0');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '13';
    document.getElementById('event_table_height').value = '30';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '12';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('ev_title_bg_color').color.fromString('EED8E9');
    document.getElementById('views_tabs_bg_color').color.fromString('FDC5F2');
    change_width();
  }
}

function reset_theme_17() {
  if (confirm('Do you really want to reset theme?')) {
    document.getElementById('width').value = '700';
    document.getElementById('cell_height').value = '70';
    document.getElementById('bg_top').color.fromString('52004F');
    document.getElementById('bg_bottom').color.fromString('E1E1E1');
    document.getElementById('border_color').color.fromString('005478');
    document.getElementById('text_color_month').color.fromString('FFFFFF');
    document.getElementById('text_color_week_days').color.fromString('00502F');
    document.getElementById('text_color_other_months').color.fromString('B0B0B0');
    document.getElementById('text_color_this_month_unevented').color.fromString('817F7F');
    document.getElementById('text_color_this_month_evented').color.fromString('817F7F');
    document.getElementById('event_title_color').color.fromString('383838');
    document.getElementById('current_day_border_color').color.fromString('52004F');
    document.getElementById('bg_color_this_month_evented').color.fromString('B69DB5');
    document.getElementById('next_prev_event_arrowcolor').color.fromString('C5B1C4');
    document.getElementById('show_event_bgcolor').color.fromString('B69DB5');
    document.getElementById('cell_border_color').color.fromString('B1B1B0');
    document.getElementById('week_days_cell_height').value = '50';
    document.getElementById('arrow_color_month').color.fromString('D1D1D1');
    document.getElementById('text_color_sun_days').color.fromString('817F7F');
    document.getElementById('title_color').color.fromString('FFFFFF');
    document.getElementById('next_prev_event_bgcolor').color.fromString('51004E');
    document.getElementById('title_font_size').value = '';
    document.getElementById('title_font').value = '';
    document.getElementById('title_style').value = 'normal';
    document.getElementById('date_color').color.fromString('FFFFFF');
    document.getElementById('date_size').value = '';
    document.getElementById('date_font').value = '';
    document.getElementById('date_style').value = 'normal';
    document.getElementById('popup_width').value = '800';
    document.getElementById('popup_height').value = '500';
    document.getElementById('number_of_shown_evetns').value = '2';
    document.getElementById('sundays_font_size').value = '25';
    document.getElementById('other_days_font_size').value = '25';
    document.getElementById('weekdays_font_size').value = '20';
    document.getElementById('border_width').value = '0';
    document.getElementById('top_height').value = '100';
    document.getElementById('bg_color_other_months').color.fromString('E1DDE9');
    document.getElementById('sundays_bg_color').color.fromString('E1E1E1');
    document.getElementById('weekdays_bg_color').color.fromString('E1E1E1');
    document.getElementById('week_start_day').value = 'su';
    document.getElementById('weekday_sunday_bg_color').color.fromString('BBBBBB');
    document.getElementById('border_radius').value = '0';
    document.getElementById('month_font_size').value = '35';
    document.getElementById('arrow_size').value = '45';
    document.getElementById('date_format').value = 'w/d/m/y';
    document.getElementById('date_bg_color').color.fromString('D6D5D5');
    document.getElementById('event_bg_color1').color.fromString('E1E1E1');
    document.getElementById('event_bg_color2').color.fromString('DEDDDD');
    document.getElementById('event_num_bg_color1').color.fromString('420040');
    document.getElementById('event_num_bg_color2').color.fromString('52004F');
    document.getElementById('event_num_color').color.fromString('FFFFFF');
    document.getElementById('day_month_font_color').color.fromString('D6D5D5');
    document.getElementById('week_font_color').color.fromString('480045');
    document.getElementById('date_font_size').value = '15';
    document.getElementById('event_num_font_size').value = '13';
    document.getElementById('event_table_height').value = '30';
    document.getElementById('date_height').value = '25';
    document.getElementById('day_month_font_size').value = '12';
    document.getElementById('week_font_size').value = '15';
    document.getElementById('ev_title_bg_color').color.fromString('C5B1C4');
    document.getElementById('views_tabs_bg_color').color.fromString('850088');
    change_width();
  }
}

function reset_theme_0() {
  document.getElementById('width').value = '';
  document.getElementById('cell_height').value = '';
  document.getElementById('bg_top').color.fromString('FFFFFF');
  document.getElementById('bg_bottom').color.fromString('FFFFFF');
  document.getElementById('border_color').color.fromString('FFFFFF');
  document.getElementById('text_color_month').color.fromString('FFFFFF');
  document.getElementById('text_color_week_days').color.fromString('FFFFFF');
  document.getElementById('text_color_other_months').color.fromString('FFFFFF');
  document.getElementById('text_color_this_month_unevented').color.fromString('FFFFFF');
  document.getElementById('text_color_this_month_evented').color.fromString('FFFFFF');
  document.getElementById('event_title_color').color.fromString('FFFFFF');
  document.getElementById('current_day_border_color').color.fromString('FFFFFF');
  document.getElementById('bg_color_this_month_evented').color.fromString('FFFFFF');
  document.getElementById('next_prev_event_arrowcolor').color.fromString('FFFFFF');
  document.getElementById('show_event_bgcolor').color.fromString('FFFFFF');
  document.getElementById('cell_border_color').color.fromString('FFFFFF');
  document.getElementById('week_days_cell_height').value = '25';
  document.getElementById('arrow_color_month').color.fromString('FFFFFF');
  document.getElementById('text_color_sun_days').color.fromString('FFFFFF');
  document.getElementById('title_color').color.fromString('FFFFFF');
  document.getElementById('next_prev_event_bgcolor').color.fromString('FFFFFF');
  document.getElementById('title_font_size').value = '';
  document.getElementById('title_font').value = '';
  document.getElementById('title_style').value = '';
  document.getElementById('date_color').color.fromString('FFFFFF');
  document.getElementById('date_size').value = '';
  document.getElementById('date_font').value = '';
  document.getElementById('date_style').value = '';
  document.getElementById('popup_width').value = '';
  document.getElementById('popup_height').value = '';
  document.getElementById('number_of_shown_evetns').value = '';
  document.getElementById('sundays_font_size').value = '';
  document.getElementById('other_days_font_size').value = '';
  document.getElementById('weekdays_font_size').value = '';
  document.getElementById('border_width').value = '';
  document.getElementById('top_height').value = '';
  document.getElementById('bg_color_other_months').color.fromString('FFFFFF');
  document.getElementById('sundays_bg_color').color.fromString('FFFFFF');
  document.getElementById('weekdays_bg_color').color.fromString('FFFFFF');
  document.getElementById('week_start_day').value = '';
  document.getElementById('weekday_sunday_bg_color').color.fromString('FFFFFF');
  document.getElementById('border_radius').value = '';
  document.getElementById('month_font_size').value = '';
  document.getElementById('arrow_size').value = '';
  document.getElementById('date_format').value = 'w/d/m/y';
  document.getElementById('views_tabs_bg_color').color.fromString('FFFFFF');
  change_width();
}


function set_theme() {
  var themeID = document.getElementById('slect_theme').value;
  switch (themeID) {
    case '0':
      reset_theme_0();
      break;

    case '1':
      reset_theme_1();
      break;

    case '2':
      reset_theme_2();
      break;

    case '3':
      reset_theme_3();
      break;

    case '4':
      reset_theme_4();
      break;

    case '5':
      reset_theme_5();
      break;

    case '6':
      reset_theme_6();
      break;

    case '7':
      reset_theme_7();
      break;

    case '8':
      reset_theme_8();
      break;

    case '9':
      reset_theme_9();
      break;

    case '10':
      reset_theme_10();
      break;

    case '11':
      reset_theme_11();
      break;

    case '12':
      reset_theme_12();
      break;

    case '13':
      reset_theme_13();
      break;

    case '14':
      reset_theme_14();
      break;

    case '15':
      reset_theme_15();
      break;

    case '16':
      reset_theme_16();
      break;

    case '17':
      reset_theme_17();
      break;
  }
  change_width();
}
