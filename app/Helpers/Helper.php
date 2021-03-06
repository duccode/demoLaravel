<?php

namespace App\Helpers;
use Illuminate\Support\Str;
class Helper
{
    public static function menu ($menus, $parent_id = 0, $char = ''){
        $html = '';

        foreach ($menus as  $key => $menu){
            if ($menu->parent_id == $parent_id){
                $html .= '
                    <tr>
                        <td>'.$menu->id.'</td>
                        <td>'.$char.$menu->name.'</td>
                        <td>'.self::active($menu->active).'</td>
                        <td>'.$menu->updated_at.'</td>
                        <td>
                            <a href="/admin/menus/edit/'.$menu->id.'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="#" onclick="RemoveRow('.$menu->id.', \'/admin/menus/destroy\')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                ';

                unset($menus[$key]);

                $html .= self::menu($menus, $menu->id,$char .'--');
            }
        }
        return $html;
    }

    public static function active($active = 0):string
    {
        return $active == 0 ?'<span class="btn btn-danger btn-xs">NO</span>':
            '<span class="btn btn-success btn-xs">YES</span>';
    }

    public static function menus($menus,$parent_id = 0) {
        $html = '';
        foreach ($menus as $key  =>$menu){
            if ($menu->parent_id == $parent_id){
                $html .= '
                    <li>
                    <a href="/danh-muc/'.$menu->id.'-'.Str::slug($menu->name,'-').'.html">
                    '.$menu->name.'
                    </a>';
                unset($menus[$key]);
                        if (self::isChild($menus,$menu->id)){
                            $html .= '<ul class="sub-menu">';
                                $html.= self::menus($menus,$menu->id);
                            $html .= '</ul>';
                        }

                    $html .= '</li>';
            }
        }
        return $html;
    }

    public static function isChild($menus,$id){
        foreach ($menus as $k => $menu){
            if ($menu->parent_id == $id){
                return true;
            }
        }
        return false;
    }

    public static function price($price,$priceSale){
        if ($priceSale != 0) return $priceSale;
        if ($price != 0) return $price;
        return '<a href="/lien-he.html"> Li??n H???</a>';
    }
}
