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
     * @property Grid\Column|Collection typeid
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection show
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection input
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
     * @property Grid\Column|Collection typedir
     * @property Grid\Column|Collection dirposition
     * @property Grid\Column|Collection seotitle
     * @property Grid\Column|Collection keywords
     * @property Grid\Column|Collection is_write
     * @property Grid\Column|Collection real_path
     * @property Grid\Column|Collection litpic
     * @property Grid\Column|Collection typeimages
     * @property Grid\Column|Collection contents
     * @property Grid\Column|Collection mid
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection shorttitle
     * @property Grid\Column|Collection tags
     * @property Grid\Column|Collection ismake
     * @property Grid\Column|Collection click
     * @property Grid\Column|Collection flags
     * @property Grid\Column|Collection write
     * @property Grid\Column|Collection body
     * @property Grid\Column|Collection published_at
     * @property Grid\Column|Collection imagepics
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection url
     * @property Grid\Column|Collection lianxi
     * @property Grid\Column|Collection state
     * @property Grid\Column|Collection linktype
     * @property Grid\Column|Collection beizhu
     * @property Grid\Column|Collection logo
     * @property Grid\Column|Collection expired_at
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection IP
     * @property Grid\Column|Collection host
     * @property Grid\Column|Collection referer
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection typeid(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection show(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
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
     * @method Grid\Column|Collection typedir(string $label = null)
     * @method Grid\Column|Collection dirposition(string $label = null)
     * @method Grid\Column|Collection seotitle(string $label = null)
     * @method Grid\Column|Collection keywords(string $label = null)
     * @method Grid\Column|Collection is_write(string $label = null)
     * @method Grid\Column|Collection real_path(string $label = null)
     * @method Grid\Column|Collection litpic(string $label = null)
     * @method Grid\Column|Collection typeimages(string $label = null)
     * @method Grid\Column|Collection contents(string $label = null)
     * @method Grid\Column|Collection mid(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection shorttitle(string $label = null)
     * @method Grid\Column|Collection tags(string $label = null)
     * @method Grid\Column|Collection ismake(string $label = null)
     * @method Grid\Column|Collection click(string $label = null)
     * @method Grid\Column|Collection flags(string $label = null)
     * @method Grid\Column|Collection write(string $label = null)
     * @method Grid\Column|Collection body(string $label = null)
     * @method Grid\Column|Collection published_at(string $label = null)
     * @method Grid\Column|Collection imagepics(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection url(string $label = null)
     * @method Grid\Column|Collection lianxi(string $label = null)
     * @method Grid\Column|Collection state(string $label = null)
     * @method Grid\Column|Collection linktype(string $label = null)
     * @method Grid\Column|Collection beizhu(string $label = null)
     * @method Grid\Column|Collection logo(string $label = null)
     * @method Grid\Column|Collection expired_at(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection IP(string $label = null)
     * @method Grid\Column|Collection host(string $label = null)
     * @method Grid\Column|Collection referer(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection typeid
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection show
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection path
     * @property Show\Field|Collection method
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection input
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
     * @property Show\Field|Collection typedir
     * @property Show\Field|Collection dirposition
     * @property Show\Field|Collection seotitle
     * @property Show\Field|Collection keywords
     * @property Show\Field|Collection is_write
     * @property Show\Field|Collection real_path
     * @property Show\Field|Collection litpic
     * @property Show\Field|Collection typeimages
     * @property Show\Field|Collection contents
     * @property Show\Field|Collection mid
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection shorttitle
     * @property Show\Field|Collection tags
     * @property Show\Field|Collection ismake
     * @property Show\Field|Collection click
     * @property Show\Field|Collection flags
     * @property Show\Field|Collection write
     * @property Show\Field|Collection body
     * @property Show\Field|Collection published_at
     * @property Show\Field|Collection imagepics
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection url
     * @property Show\Field|Collection lianxi
     * @property Show\Field|Collection state
     * @property Show\Field|Collection linktype
     * @property Show\Field|Collection beizhu
     * @property Show\Field|Collection logo
     * @property Show\Field|Collection expired_at
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection IP
     * @property Show\Field|Collection host
     * @property Show\Field|Collection referer
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection typeid(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection show(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
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
     * @method Show\Field|Collection typedir(string $label = null)
     * @method Show\Field|Collection dirposition(string $label = null)
     * @method Show\Field|Collection seotitle(string $label = null)
     * @method Show\Field|Collection keywords(string $label = null)
     * @method Show\Field|Collection is_write(string $label = null)
     * @method Show\Field|Collection real_path(string $label = null)
     * @method Show\Field|Collection litpic(string $label = null)
     * @method Show\Field|Collection typeimages(string $label = null)
     * @method Show\Field|Collection contents(string $label = null)
     * @method Show\Field|Collection mid(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection shorttitle(string $label = null)
     * @method Show\Field|Collection tags(string $label = null)
     * @method Show\Field|Collection ismake(string $label = null)
     * @method Show\Field|Collection click(string $label = null)
     * @method Show\Field|Collection flags(string $label = null)
     * @method Show\Field|Collection write(string $label = null)
     * @method Show\Field|Collection body(string $label = null)
     * @method Show\Field|Collection published_at(string $label = null)
     * @method Show\Field|Collection imagepics(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection url(string $label = null)
     * @method Show\Field|Collection lianxi(string $label = null)
     * @method Show\Field|Collection state(string $label = null)
     * @method Show\Field|Collection linktype(string $label = null)
     * @method Show\Field|Collection beizhu(string $label = null)
     * @method Show\Field|Collection logo(string $label = null)
     * @method Show\Field|Collection expired_at(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection IP(string $label = null)
     * @method Show\Field|Collection host(string $label = null)
     * @method Show\Field|Collection referer(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
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
