<div>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <x-filament-panels::form id="form" wire:submit="authenticate">
        {{ $this->form }}

        <button type="submit"
                wire:loading.attr="disabled"
                wire:target="authenticate"
                onmouseover="this.style.backgroundColor='#0c584c'"
                onmouseout="this.style.backgroundColor='#0b433a'"
                style="display: flex; width: 100%; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 0.75rem; background-color: #0b433a; color: #fafaf7; padding: 0.75rem 1rem; font-size: 0.875rem; font-weight: 600; border: none; cursor: pointer; transition: background-color 0.2s;">
            <span wire:loading.remove wire:target="authenticate">Masuk</span>
            <span wire:loading wire:target="authenticate">Memproses...</span>
        </button>
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
</div>
