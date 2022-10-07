<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{Hash, Storage, Auth};
use App\Models\{User, UserHeader};
use App\Http\Requests\HeaderRequest;

class HeaderService
{
    public static function storeHeader(HeaderRequest $request, User $user): UserHeader
    {
        $imageName =  Self::saveImageAjax($request);
        $header = UserHeader::create(
            array_merge(
                $request->input('header'),
                ['user_id'=>$user->id,
                 'logo' => $imageName]
            )
        );
        return $header;
    }

    public static function updateHeader(HeaderRequest $request, UserHeader $header): UserHeader
    {
        $imageName =  Self::saveImageAjax($request, $header);

        $header->update(
            array_merge(
                $request->input('header'),
                ['logo' => $imageName]
            )
        );
        return $header;
    }

    private static function storeImage(HeaderRequest $request, UserHeader $header = null): string
    {
        if(!is_null($header) && $header->logo) {
            $filePath = $header->getRawOriginal('logo');
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        if ( $request->hasFile('header.logo') && $request->file('header.logo') ) {
            $fileName = uniqid(date('HisYmd')) . ".{$request->file('header.logo')->extension()}";
            Storage::putFileAs(
                'public/headers', $request->file('header.logo'), $fileName
            );
            return 'headers/' . $fileName;
        }else{
            return null;
        }
    }

    private static function saveImageAjax(HeaderRequest $request, UserHeader $header = null): string
    {
        if($request['header']['logo']){
            if(!is_null($header) && $header->logo) {
                $filePath = $header->getRawOriginal('logo');
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            $image_array_1 = explode(";", $request['header']['logo']);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $fileName = uniqid(date('HisYmd')) . ".png";
            file_put_contents( 'storage/headers/'.$fileName, $data);
            return 'headers/' . $fileName;
        }
    }

    public static function updateOnlyLogo($imagem, UserHeader $header){
        if(!is_null($header) && $header->logo) {
            $filePath = $header->getRawOriginal('logo');
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        if ( $imagem ) {
            $fileName = uniqid(date('HisYmd')) . ".png";

            Storage::putFileAs(
                'public/headers', $imagem, $fileName
            );
            $header['logo'] = 'headers/'.$fileName;
            $header->update();
        }
    }

    public static function deleteHeader(UserHeader $header): void
    {
        $header->delete();
    }

    public static function forceDeleteHeader(UserHeader $header): void
    {
        $header->forceDelete();
    }

    public static function restoreHeader(UserHeader $header): void
    {
        $header->restore();
    }
}
