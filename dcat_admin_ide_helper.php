<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection role
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection has_pay
     * @property Grid\Column|Collection sign_sex
     * @property Grid\Column|Collection access_token
     * @property Grid\Column|Collection expires_in
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection valid_time
     * @property Grid\Column|Collection bg_banner
     * @property Grid\Column|Collection is_many
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection creater_id
     * @property Grid\Column|Collection ori_price
     * @property Grid\Column|Collection real_price
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection start_time
     * @property Grid\Column|Collection end_time
     * @property Grid\Column|Collection views_num
     * @property Grid\Column|Collection buy_num
     * @property Grid\Column|Collection share_num
     * @property Grid\Column|Collection com_sign_num
     * @property Grid\Column|Collection share_bg
     * @property Grid\Column|Collection share_q_code
     * @property Grid\Column|Collection merge_img
     * @property Grid\Column|Collection a_invite_money
     * @property Grid\Column|Collection a_other_money
     * @property Grid\Column|Collection second_invite_money
     * @property Grid\Column|Collection deal_group_num
     * @property Grid\Column|Collection activity_id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection num
     * @property Grid\Column|Collection current_num
     * @property Grid\Column|Collection leader_id
     * @property Grid\Column|Collection leader_wx_name
     * @property Grid\Column|Collection leader_boy_name
     * @property Grid\Column|Collection finished
     * @property Grid\Column|Collection success_time
     * @property Grid\Column|Collection company_id
     * @property Grid\Column|Collection group_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection order_no
     * @property Grid\Column|Collection money
     * @property Grid\Column|Collection pay_time
     * @property Grid\Column|Collection pay_cancel_time
     * @property Grid\Column|Collection sign_name
     * @property Grid\Column|Collection sign_mobile
     * @property Grid\Column|Collection sign_age
     * @property Grid\Column|Collection is_agree
     * @property Grid\Column|Collection info_two
     * @property Grid\Column|Collection info_one
     * @property Grid\Column|Collection school_id
     * @property Grid\Column|Collection course_id
     * @property Grid\Column|Collection sign_user_id
     * @property Grid\Column|Collection order_num
     * @property Grid\Column|Collection shop_name
     * @property Grid\Column|Collection contacter
     * @property Grid\Column|Collection mobile
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection short_name
     * @property Grid\Column|Collection logo
     * @property Grid\Column|Collection invite_num
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection is_commander
     * @property Grid\Column|Collection group_ok
     * @property Grid\Column|Collection is_free
     * @property Grid\Column|Collection buy_protocal
     * @property Grid\Column|Collection my_activity_pic
     * @property Grid\Column|Collection my_activity_mobile
     * @property Grid\Column|Collection intruduction
     * @property Grid\Column|Collection video_url
     * @property Grid\Column|Collection map_area
     * @property Grid\Column|Collection map_points
     * @property Grid\Column|Collection wx_pic
     * @property Grid\Column|Collection total_num
     * @property Grid\Column|Collection sale_num
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection invite_pic
     * @property Grid\Column|Collection A_user_id
     * @property Grid\Column|Collection parent_user_id
     * @property Grid\Column|Collection invited_user_id
     * @property Grid\Column|Collection apply_money
     * @property Grid\Column|Collection history_total_money
     * @property Grid\Column|Collection current_stay_money
     * @property Grid\Column|Collection pay_order
     * @property Grid\Column|Collection pay_status
     * @property Grid\Column|Collection award_id
     * @property Grid\Column|Collection audit_id
     * @property Grid\Column|Collection audit_time
     * @property Grid\Column|Collection area
     * @property Grid\Column|Collection gap
     * @property Grid\Column|Collection add_new_address_status
     * @property Grid\Column|Collection openid
     * @property Grid\Column|Collection email_verified_at
     * @property Grid\Column|Collection is_A
     * @property Grid\Column|Collection gender
     * @property Grid\Column|Collection country
     * @property Grid\Column|Collection province
     * @property Grid\Column|Collection city
     * @property Grid\Column|Collection session
     * @property Grid\Column|Collection time_login
     * @property Grid\Column|Collection address
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection role(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection has_pay(string $label = null)
     * @method Grid\Column|Collection sign_sex(string $label = null)
     * @method Grid\Column|Collection access_token(string $label = null)
     * @method Grid\Column|Collection expires_in(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection valid_time(string $label = null)
     * @method Grid\Column|Collection bg_banner(string $label = null)
     * @method Grid\Column|Collection is_many(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection creater_id(string $label = null)
     * @method Grid\Column|Collection ori_price(string $label = null)
     * @method Grid\Column|Collection real_price(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection start_time(string $label = null)
     * @method Grid\Column|Collection end_time(string $label = null)
     * @method Grid\Column|Collection views_num(string $label = null)
     * @method Grid\Column|Collection buy_num(string $label = null)
     * @method Grid\Column|Collection share_num(string $label = null)
     * @method Grid\Column|Collection com_sign_num(string $label = null)
     * @method Grid\Column|Collection share_bg(string $label = null)
     * @method Grid\Column|Collection share_q_code(string $label = null)
     * @method Grid\Column|Collection merge_img(string $label = null)
     * @method Grid\Column|Collection a_invite_money(string $label = null)
     * @method Grid\Column|Collection a_other_money(string $label = null)
     * @method Grid\Column|Collection second_invite_money(string $label = null)
     * @method Grid\Column|Collection deal_group_num(string $label = null)
     * @method Grid\Column|Collection activity_id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection num(string $label = null)
     * @method Grid\Column|Collection current_num(string $label = null)
     * @method Grid\Column|Collection leader_id(string $label = null)
     * @method Grid\Column|Collection leader_wx_name(string $label = null)
     * @method Grid\Column|Collection leader_boy_name(string $label = null)
     * @method Grid\Column|Collection finished(string $label = null)
     * @method Grid\Column|Collection success_time(string $label = null)
     * @method Grid\Column|Collection company_id(string $label = null)
     * @method Grid\Column|Collection group_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection order_no(string $label = null)
     * @method Grid\Column|Collection money(string $label = null)
     * @method Grid\Column|Collection pay_time(string $label = null)
     * @method Grid\Column|Collection pay_cancel_time(string $label = null)
     * @method Grid\Column|Collection sign_name(string $label = null)
     * @method Grid\Column|Collection sign_mobile(string $label = null)
     * @method Grid\Column|Collection sign_age(string $label = null)
     * @method Grid\Column|Collection is_agree(string $label = null)
     * @method Grid\Column|Collection info_two(string $label = null)
     * @method Grid\Column|Collection info_one(string $label = null)
     * @method Grid\Column|Collection school_id(string $label = null)
     * @method Grid\Column|Collection course_id(string $label = null)
     * @method Grid\Column|Collection sign_user_id(string $label = null)
     * @method Grid\Column|Collection order_num(string $label = null)
     * @method Grid\Column|Collection shop_name(string $label = null)
     * @method Grid\Column|Collection contacter(string $label = null)
     * @method Grid\Column|Collection mobile(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection short_name(string $label = null)
     * @method Grid\Column|Collection logo(string $label = null)
     * @method Grid\Column|Collection invite_num(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection is_commander(string $label = null)
     * @method Grid\Column|Collection group_ok(string $label = null)
     * @method Grid\Column|Collection is_free(string $label = null)
     * @method Grid\Column|Collection buy_protocal(string $label = null)
     * @method Grid\Column|Collection my_activity_pic(string $label = null)
     * @method Grid\Column|Collection my_activity_mobile(string $label = null)
     * @method Grid\Column|Collection intruduction(string $label = null)
     * @method Grid\Column|Collection video_url(string $label = null)
     * @method Grid\Column|Collection map_area(string $label = null)
     * @method Grid\Column|Collection map_points(string $label = null)
     * @method Grid\Column|Collection wx_pic(string $label = null)
     * @method Grid\Column|Collection total_num(string $label = null)
     * @method Grid\Column|Collection sale_num(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection invite_pic(string $label = null)
     * @method Grid\Column|Collection A_user_id(string $label = null)
     * @method Grid\Column|Collection parent_user_id(string $label = null)
     * @method Grid\Column|Collection invited_user_id(string $label = null)
     * @method Grid\Column|Collection apply_money(string $label = null)
     * @method Grid\Column|Collection history_total_money(string $label = null)
     * @method Grid\Column|Collection current_stay_money(string $label = null)
     * @method Grid\Column|Collection pay_order(string $label = null)
     * @method Grid\Column|Collection pay_status(string $label = null)
     * @method Grid\Column|Collection award_id(string $label = null)
     * @method Grid\Column|Collection audit_id(string $label = null)
     * @method Grid\Column|Collection audit_time(string $label = null)
     * @method Grid\Column|Collection area(string $label = null)
     * @method Grid\Column|Collection gap(string $label = null)
     * @method Grid\Column|Collection add_new_address_status(string $label = null)
     * @method Grid\Column|Collection openid(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     * @method Grid\Column|Collection is_A(string $label = null)
     * @method Grid\Column|Collection gender(string $label = null)
     * @method Grid\Column|Collection country(string $label = null)
     * @method Grid\Column|Collection province(string $label = null)
     * @method Grid\Column|Collection city(string $label = null)
     * @method Grid\Column|Collection session(string $label = null)
     * @method Grid\Column|Collection time_login(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection role
     * @property Show\Field|Collection type
     * @property Show\Field|Collection has_pay
     * @property Show\Field|Collection sign_sex
     * @property Show\Field|Collection access_token
     * @property Show\Field|Collection expires_in
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection valid_time
     * @property Show\Field|Collection bg_banner
     * @property Show\Field|Collection is_many
     * @property Show\Field|Collection content
     * @property Show\Field|Collection creater_id
     * @property Show\Field|Collection ori_price
     * @property Show\Field|Collection real_price
     * @property Show\Field|Collection status
     * @property Show\Field|Collection start_time
     * @property Show\Field|Collection end_time
     * @property Show\Field|Collection views_num
     * @property Show\Field|Collection buy_num
     * @property Show\Field|Collection share_num
     * @property Show\Field|Collection com_sign_num
     * @property Show\Field|Collection share_bg
     * @property Show\Field|Collection share_q_code
     * @property Show\Field|Collection merge_img
     * @property Show\Field|Collection a_invite_money
     * @property Show\Field|Collection a_other_money
     * @property Show\Field|Collection second_invite_money
     * @property Show\Field|Collection deal_group_num
     * @property Show\Field|Collection activity_id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection num
     * @property Show\Field|Collection current_num
     * @property Show\Field|Collection leader_id
     * @property Show\Field|Collection leader_wx_name
     * @property Show\Field|Collection leader_boy_name
     * @property Show\Field|Collection finished
     * @property Show\Field|Collection success_time
     * @property Show\Field|Collection company_id
     * @property Show\Field|Collection group_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection order_no
     * @property Show\Field|Collection money
     * @property Show\Field|Collection pay_time
     * @property Show\Field|Collection pay_cancel_time
     * @property Show\Field|Collection sign_name
     * @property Show\Field|Collection sign_mobile
     * @property Show\Field|Collection sign_age
     * @property Show\Field|Collection is_agree
     * @property Show\Field|Collection info_two
     * @property Show\Field|Collection info_one
     * @property Show\Field|Collection school_id
     * @property Show\Field|Collection course_id
     * @property Show\Field|Collection sign_user_id
     * @property Show\Field|Collection order_num
     * @property Show\Field|Collection shop_name
     * @property Show\Field|Collection contacter
     * @property Show\Field|Collection mobile
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection short_name
     * @property Show\Field|Collection logo
     * @property Show\Field|Collection invite_num
     * @property Show\Field|Collection price
     * @property Show\Field|Collection is_commander
     * @property Show\Field|Collection group_ok
     * @property Show\Field|Collection is_free
     * @property Show\Field|Collection buy_protocal
     * @property Show\Field|Collection my_activity_pic
     * @property Show\Field|Collection my_activity_mobile
     * @property Show\Field|Collection intruduction
     * @property Show\Field|Collection video_url
     * @property Show\Field|Collection map_area
     * @property Show\Field|Collection map_points
     * @property Show\Field|Collection wx_pic
     * @property Show\Field|Collection total_num
     * @property Show\Field|Collection sale_num
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection invite_pic
     * @property Show\Field|Collection A_user_id
     * @property Show\Field|Collection parent_user_id
     * @property Show\Field|Collection invited_user_id
     * @property Show\Field|Collection apply_money
     * @property Show\Field|Collection history_total_money
     * @property Show\Field|Collection current_stay_money
     * @property Show\Field|Collection pay_order
     * @property Show\Field|Collection pay_status
     * @property Show\Field|Collection award_id
     * @property Show\Field|Collection audit_id
     * @property Show\Field|Collection audit_time
     * @property Show\Field|Collection area
     * @property Show\Field|Collection gap
     * @property Show\Field|Collection add_new_address_status
     * @property Show\Field|Collection openid
     * @property Show\Field|Collection email_verified_at
     * @property Show\Field|Collection is_A
     * @property Show\Field|Collection gender
     * @property Show\Field|Collection country
     * @property Show\Field|Collection province
     * @property Show\Field|Collection city
     * @property Show\Field|Collection session
     * @property Show\Field|Collection time_login
     * @property Show\Field|Collection address
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection role(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection has_pay(string $label = null)
     * @method Show\Field|Collection sign_sex(string $label = null)
     * @method Show\Field|Collection access_token(string $label = null)
     * @method Show\Field|Collection expires_in(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection valid_time(string $label = null)
     * @method Show\Field|Collection bg_banner(string $label = null)
     * @method Show\Field|Collection is_many(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection creater_id(string $label = null)
     * @method Show\Field|Collection ori_price(string $label = null)
     * @method Show\Field|Collection real_price(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection start_time(string $label = null)
     * @method Show\Field|Collection end_time(string $label = null)
     * @method Show\Field|Collection views_num(string $label = null)
     * @method Show\Field|Collection buy_num(string $label = null)
     * @method Show\Field|Collection share_num(string $label = null)
     * @method Show\Field|Collection com_sign_num(string $label = null)
     * @method Show\Field|Collection share_bg(string $label = null)
     * @method Show\Field|Collection share_q_code(string $label = null)
     * @method Show\Field|Collection merge_img(string $label = null)
     * @method Show\Field|Collection a_invite_money(string $label = null)
     * @method Show\Field|Collection a_other_money(string $label = null)
     * @method Show\Field|Collection second_invite_money(string $label = null)
     * @method Show\Field|Collection deal_group_num(string $label = null)
     * @method Show\Field|Collection activity_id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection num(string $label = null)
     * @method Show\Field|Collection current_num(string $label = null)
     * @method Show\Field|Collection leader_id(string $label = null)
     * @method Show\Field|Collection leader_wx_name(string $label = null)
     * @method Show\Field|Collection leader_boy_name(string $label = null)
     * @method Show\Field|Collection finished(string $label = null)
     * @method Show\Field|Collection success_time(string $label = null)
     * @method Show\Field|Collection company_id(string $label = null)
     * @method Show\Field|Collection group_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection order_no(string $label = null)
     * @method Show\Field|Collection money(string $label = null)
     * @method Show\Field|Collection pay_time(string $label = null)
     * @method Show\Field|Collection pay_cancel_time(string $label = null)
     * @method Show\Field|Collection sign_name(string $label = null)
     * @method Show\Field|Collection sign_mobile(string $label = null)
     * @method Show\Field|Collection sign_age(string $label = null)
     * @method Show\Field|Collection is_agree(string $label = null)
     * @method Show\Field|Collection info_two(string $label = null)
     * @method Show\Field|Collection info_one(string $label = null)
     * @method Show\Field|Collection school_id(string $label = null)
     * @method Show\Field|Collection course_id(string $label = null)
     * @method Show\Field|Collection sign_user_id(string $label = null)
     * @method Show\Field|Collection order_num(string $label = null)
     * @method Show\Field|Collection shop_name(string $label = null)
     * @method Show\Field|Collection contacter(string $label = null)
     * @method Show\Field|Collection mobile(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection short_name(string $label = null)
     * @method Show\Field|Collection logo(string $label = null)
     * @method Show\Field|Collection invite_num(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection is_commander(string $label = null)
     * @method Show\Field|Collection group_ok(string $label = null)
     * @method Show\Field|Collection is_free(string $label = null)
     * @method Show\Field|Collection buy_protocal(string $label = null)
     * @method Show\Field|Collection my_activity_pic(string $label = null)
     * @method Show\Field|Collection my_activity_mobile(string $label = null)
     * @method Show\Field|Collection intruduction(string $label = null)
     * @method Show\Field|Collection video_url(string $label = null)
     * @method Show\Field|Collection map_area(string $label = null)
     * @method Show\Field|Collection map_points(string $label = null)
     * @method Show\Field|Collection wx_pic(string $label = null)
     * @method Show\Field|Collection total_num(string $label = null)
     * @method Show\Field|Collection sale_num(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection invite_pic(string $label = null)
     * @method Show\Field|Collection A_user_id(string $label = null)
     * @method Show\Field|Collection parent_user_id(string $label = null)
     * @method Show\Field|Collection invited_user_id(string $label = null)
     * @method Show\Field|Collection apply_money(string $label = null)
     * @method Show\Field|Collection history_total_money(string $label = null)
     * @method Show\Field|Collection current_stay_money(string $label = null)
     * @method Show\Field|Collection pay_order(string $label = null)
     * @method Show\Field|Collection pay_status(string $label = null)
     * @method Show\Field|Collection award_id(string $label = null)
     * @method Show\Field|Collection audit_id(string $label = null)
     * @method Show\Field|Collection audit_time(string $label = null)
     * @method Show\Field|Collection area(string $label = null)
     * @method Show\Field|Collection gap(string $label = null)
     * @method Show\Field|Collection add_new_address_status(string $label = null)
     * @method Show\Field|Collection openid(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     * @method Show\Field|Collection is_A(string $label = null)
     * @method Show\Field|Collection gender(string $label = null)
     * @method Show\Field|Collection country(string $label = null)
     * @method Show\Field|Collection province(string $label = null)
     * @method Show\Field|Collection city(string $label = null)
     * @method Show\Field|Collection session(string $label = null)
     * @method Show\Field|Collection time_login(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
