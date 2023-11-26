<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PinjamRuangCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection
                ->transform(function ($item) {
                    $jam_mulai = Carbon::parse($item->tanggal_mulai_pinjam)->format('H:i');
                    $jam_akhir = Carbon::parse($item->tanggal_akhir_pinjam)->format('H:i');
                    $tanggal_mulai = Carbon::parse($item->tanggal_mulai_pinjam)->format('Y-m-d');
                    $tanggal_akhir = Carbon::parse($item->tanggal_akhir_pinjam)->format('Y-m-d');

                    return [
                        'title' => $jam_mulai . '-' . $jam_akhir . ' | ' . $item->nama_kegiatan,
                        'start' => $tanggal_mulai,
                        'end' => $tanggal_akhir
                    ];
                })
                ->values(),
        ];
    }
}
