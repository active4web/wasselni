<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*$lang['form_validation_required']		= 'The {field} field is required.';
$lang['form_validation_isset']			= 'The {field} field must have a value.';
$lang['form_validation_valid_email']		= 'The {field} field must contain a valid email address.';
$lang['form_validation_valid_emails']		= 'The {field} field must contain all valid email addresses.';
$lang['form_validation_valid_url']		= 'The {field} field must contain a valid URL.';
$lang['form_validation_valid_ip']		= 'The {field} field must contain a valid IP.';
$lang['form_validation_min_length']		= 'The {field} field must be at least {param} characters in length.';
$lang['form_validation_max_length']		= 'The {field} field cannot exceed {param} characters in length.';
$lang['form_validation_exact_length']		= 'The {field} field must be exactly {param} characters in length.';
$lang['form_validation_alpha']			= 'The {field} field may only contain alphabetical characters.';
$lang['form_validation_alpha_numeric']		= 'The {field} field may only contain alpha-numeric characters.';
$lang['form_validation_alpha_numeric_spaces']	= 'The {field} field may only contain alpha-numeric characters and spaces.';
$lang['form_validation_alpha_dash']		= 'The {field} field may only contain alpha-numeric characters, underscores, and dashes.';
$lang['form_validation_numeric']		= 'The {field} field must contain only numbers.';
$lang['form_validation_is_numeric']		= 'The {field} field must contain only numeric characters.';
$lang['form_validation_integer']		= 'The {field} field must contain an integer.';
$lang['form_validation_regex_match']		= 'The {field} field is not in the correct format.';
$lang['form_validation_matches']		= 'The {field} field does not match the {param} field.';
$lang['form_validation_differs']		= 'The {field} field must differ from the {param} field.';
$lang['form_validation_is_unique'] 		= 'The {field} field must contain a unique value.';
$lang['form_validation_is_natural']		= 'The {field} field must only contain digits.';
$lang['form_validation_is_natural_no_zero']	= 'The {field} field must only contain digits and must be greater than zero.';
$lang['form_validation_decimal']		= 'The {field} field must contain a decimal number.';
$lang['form_validation_less_than']		= 'The {field} field must contain a number less than {param}.';
$lang['form_validation_less_than_equal_to']	= 'The {field} field must contain a number less than or equal to {param}.';
$lang['form_validation_greater_than']		= 'The {field} field must contain a number greater than {param}.';
$lang['form_validation_greater_than_equal_to']	= 'The {field} field must contain a number greater than or equal to {param}.';
$lang['form_validation_error_message_not_set']	= 'Unable to access an error message corresponding to your field name {field}.';
$lang['form_validation_in_list']		= 'The {field} field must be one of: {param}.';*/

$lang['required']  = 'حقل %s مطلوب.';
$lang['isset']  = 'يجب أن يحتوي %s قيمة.';
$lang['valid_email']  = 'يجب أن يحتوي %s عنوان بريد إلكتروني صحيح.';
$lang['valid_emails']  = 'يجب أن يحتوي الحقل %s على عناوين بريد إلكتروني صحيحة.';
$lang['valid_url']  = 'يجب أن يحتوي الحقل %s عنوان URL صحيح.';
$lang['valid_ip']  = 'يجب أن يحتوي الحقل %s عنوان IP صحيح.';
$lang['min_length']  = 'يجب أن يكون عدد أحرف %s على الأقل %s.';
$lang['max_length']  = 'يجب أن لا يزيد عدد أحرف %s عن %s.';
$lang['exact_length']  = 'يجب أن يتكون %s من %s أحرف بالضبط.';
$lang['alpha']  = 'يجب أن يحتوي %s أحرفاً فقط.';
$lang['alpha_numeric']  = 'يجب أن يحتوي %s أحرفاً إنجليزية وأرقاماً فقط.';
$lang['alpha_dash']  = 'يجب أن يحتوي %s على أرقام وأحرف وعلامتي - و _ فقط.';
$lang['numeric']  = 'يجب أن يحتوي %s على أعداد فقط.';
$lang['is_numeric']  = 'يجب أن يحتوي %s أعداد فقط.';
$lang['integer']  = 'يجب أن يحتوي %s على عدد.';
$lang['regex_match']  = 'الحقل %s ليس مكتوباً بالنسق الصحيح.';
$lang['matches']  = 'قيمة %s لا تطابق قيمة %s.';
$lang['is_unique']  = '%s مسجل من قبل.';
$lang['is_natural']  = 'يجب أن يحتوي %s أرقام موجبة فقط.';
$lang['is_natural_no_zero'] = 'يجب أن يحتوي %s رقماً أكبر من الصفر.';
$lang['decimal']  = 'يجب ان يحتوي %s على رقم عشري..';
$lang['less_than']  = 'يجب ان يحتوي %1 على عدد اصغر من %s.';
$lang['greater_than']  = 'يجب ان يحتوي %1 على عدد اكبر من %s.';
