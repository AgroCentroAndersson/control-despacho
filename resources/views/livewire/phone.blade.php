<div>
    <x-inputs.maskable
        class="mb-4 !pl-[4rem]"
        label="Telefono"
        name="phone"
        mask="########"
        placeholder="55555555"
        prefix="+502"
        value="{{ old('phone', '') }}"
    />
</div>
