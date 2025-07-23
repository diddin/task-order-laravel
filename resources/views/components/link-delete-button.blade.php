@props([
    'action',
    'confirm' => 'Yakin hapus?',
    'teks' => 'Hapus'
])

<form action="{{ $action }}" method="POST"
      onsubmit="return confirm('{{ $confirm }}')"
      {{ $attributes->merge(['class' => 'w-full sm:w-auto']) }}>
    @csrf
    @method('DELETE')
    <button type="submit"
            class="w-full sm:w-auto px-3 py-1 text-sm font-medium text-red-600 bg-red-100 hover:bg-red-200 rounded-full transition text-center">
        {{ $teks }}
    </button>
</form>
