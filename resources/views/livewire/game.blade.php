@livewireStyles
<div>
    {{-- The best athlete wants his opponent at his best. --}}
    @livewire('word')
    
    <input value="{{$word}}" type="text" wire:model="word" class="form-control">
    <button wire:click="set" class="btn btn-info">test</button>
</div>
@livewireScripts