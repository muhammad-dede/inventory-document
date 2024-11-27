<?php

namespace App\Filament\Resources\RetrievalResource\Pages;

use App\Filament\Resources\RetrievalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRetrieval extends EditRecord
{
    protected static string $resource = RetrievalResource::class;

    protected function afterSave(): void
    {
        $record = $this->record;
        foreach ($record->retrievalItems as $item) {
            $item->update([
                'section_code' => $record->section_code,
                'pic_id' => $record->pic_id,
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
