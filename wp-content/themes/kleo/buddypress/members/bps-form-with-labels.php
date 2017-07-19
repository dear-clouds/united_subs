<?php

/*
 * BP Profile Search - form template 'bps-form-legacy'
 *
 * See http://dontdream.it/bp-profile-search/form-templates/ if you wish to modify this template or develop a new one.
 *
 */

$F = bps_escaped_form_data ();

$toggle_id = 'bps_toggle'. $F->id;
$form_id = 'bps_'. $F->location. $F->id;

if ($F->location != 'directory')
{
    $action = $F->action;
    echo "<div id='buddypress'>";
}
else
{
    $action = parse_url ($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    ?>
    <div class="item-list-tabs bps_header">
        <ul>
            <li><?php echo $F->header; ?></li>
            <?php
            if ($F->toggle)
            {
                ?>
                <li class="last">
                    <input id="<?php echo $toggle_id; ?>" type="submit" value="<?php echo $F->toggle_text; ?>">
                </li>
                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        $('#<?php echo $form_id; ?>').hide();
                        $('#<?php echo $toggle_id; ?>').click(function(){
                            $('#<?php echo $form_id; ?>').toggle();
                        });
                    });
                </script>
            <?php
            }
            ?>
        </ul>
    </div>
<?php
}

echo "<form action='$F->action' method='$F->method' id='$form_id' class='bps-form bps-form-labels clear clearfix'>\n";

$j = 0;
foreach ($F->fields as $f)
{
    if ($f->display == 'hidden')
    {
        echo "<input type='hidden' name='$f->code' value='$f->value'>\n";
        continue;
    }

    $name = sanitize_title ($f->name);
    $alt = ($j++ % 2)? 'alt': '';
    $class = "editfield field_$f->id field_$name $alt";

    if ($f->display != 'range') {
        $class .= ' form-group';
    }

    echo "<div class='$class'>\n";

    switch ($f->display)
    {
        case 'range':

        echo "<label for='$f->code'>$f->label</label>\n";
        echo "<input type='text' name='{$f->code}_min' id='$f->code' value='$f->min' class='form-control input-range'>";
        echo '&nbsp;-&nbsp;';
        echo "<input type='text' name='{$f->code}_max' value='$f->max' class='form-control input-range'>\n";
        break;

        case 'textbox':
        case 'textarea':
            echo "<label for='$f->code'>$f->label</label>\n";
            echo "<input type='text' name='$f->code' id='$f->code' value='$f->value' class='form-control'>\n";
            break;

        case 'number':
            echo "<label for='$f->code'>$f->label</label>\n";
            echo "<input type='number' name='$f->code' id='$f->code' value='$f->value' class='form-control'>\n";
            break;

        case 'url':
            echo "<label for='$f->code'>$f->label</label>\n";
            echo "<input type='text' inputmode='url' name='$f->code' id='$f->code' value='$f->value' class='form-control'>\n";
            break;


        case 'selectbox':
            echo "<label for='$f->code'>$f->label</label>\n";
            echo "<select name='$f->code' id='$f->code' class='form-control'>\n";

            $no_selection = apply_filters ('bps_field_selectbox_no_selection', $f->label, $f);
            if (is_string ($no_selection)) {
                echo "<option  value=''>$no_selection</option>\n";
            }

            foreach ($f->options as $key => $label)
            {
                $selected = in_array ($key, $f->values)? "selected='selected'": "";
                echo "<option $selected value='$key'>$label</option>\n";
            }
            echo "</select>\n";
            break;

        case 'multiselectbox':
            echo "<label for='$f->code'>$f->label</label>\n";
            echo "<select name='{$f->code}[]' id='$f->code' multiple='multiple' class='form-control'>\n";

            foreach ($f->options as $key => $label)
            {
                $selected = in_array ($key, $f->values)? "selected='selected'": "";
                echo "<option $selected value='$key'>$label</option>\n";
            }
            echo "</select>\n";
            break;

        case 'radio':

            echo "<label>$f->label</label>\n";
            echo "<div id='$f->code'>\n";

            foreach ($f->options as $key => $label)
            {
                $checked = in_array ($key, $f->values)? "checked='checked'": "";
                echo "<div class='radio'>\n";
                echo "<label><input $checked type='radio' name='$f->code' value='$key'>$label</label>\n";
                echo "</div>\n";
            }

            echo "<a class='clear-value' href='javascript:clear(\"$f->code\");'>". __('Clear', 'buddypress'). "</a>\n";
            echo "</div>\n";
            break;

        case 'checkbox':

            echo "<label>$f->label</label>\n";

            foreach ($f->options as $key => $label)
            {
                $checked = in_array ($key, $f->values)? "checked='checked'": "";
                echo "<div class='checkbox'>\n";
                echo "<label><input $checked type='checkbox' name='{$f->code}[]' value='$key'>$label</label>\n";
                echo "</div>\n";
            }

            break;

        default:
            echo "<p>BP Profile Search: don't know how to display the <em>$f->display</em> field type.</p>\n";
            break;
    }

    if (!empty ($f->description) && $f->description != '-')
        echo "<p class='description'>$f->description</p>\n";

    echo "</div>\n";
}

echo "<input type='hidden' name='bp_profile_search' value='$F->id'>\n";
echo '<a href="#" class="btn btn-highlight form-submit">'. __("Search") . '</a>';
echo "</form>\n";

if ($F->location != 'directory')  echo "</div>\n";

// BP Profile Search - end of template
