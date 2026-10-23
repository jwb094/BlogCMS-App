<div class="mb-3">
    <x-form.label for="featured_image_upload" class="form-label d-block">Featured Image</x-form.label>
    <input type="hidden" id="featured_image" name="featured_image" value="{{ $selectedImage }}">

    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#featuredImageGalleryModal">
            Choose from gallery
        </button>
        <span id="selected-featured-image-name" class="small text-muted">
            {{ $selectedImage ? basename($selectedImage) : 'No gallery image selected' }}
        </span>
    </div>

    <input id="featured_image_upload" name="featured_image_upload" type="file" accept="image/jpeg,image/png,image/gif,image/webp" class="form-control">
    <div class="form-text">Images are saved in your featured image gallery. Maximum file size: 5 MB.</div>
    @error('featured_image') <div class="text-danger small">{{ $message }}</div> @enderror
    @error('featured_image_upload') <div class="text-danger small">{{ $message }}</div> @enderror

    <div class="modal fade" id="featuredImageGalleryModal" tabindex="-1" aria-labelledby="featuredImageGalleryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="featuredImageGalleryModalLabel">Your Featured Image Gallery</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (count($featuredImages) > 0)
                        <div class="row g-3">
                            @foreach ($featuredImages as $image)
                                <div class="col-6 col-md-4 col-xl-3">
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary w-100 h-100 p-2 text-start featured-image-choice {{ $selectedImage === $image ? 'active' : '' }}"
                                        data-image-path="{{ $image }}"
                                        data-image-name="{{ basename($image) }}"
                                        data-bs-dismiss="modal"
                                    >
                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image) }}"
                                            alt="Featured image {{ basename($image) }}"
                                            class="img-fluid rounded"
                                            style="height: 140px; width: 100%; object-fit: cover;"
                                        >
                                        <span class="small text-truncate d-block mt-2">{{ basename($image) }}</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">You have no saved featured images yet. Upload one below.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const selectedImage = document.getElementById('featured_image');
                const imageUpload = document.getElementById('featured_image_upload');
                const selectedImageName = document.getElementById('selected-featured-image-name');
                const imageChoices = document.querySelectorAll('.featured-image-choice');

                imageChoices.forEach((choice) => {
                    choice.addEventListener('click', () => {
                        selectedImage.value = choice.dataset.imagePath;
                        selectedImageName.textContent = choice.dataset.imageName;
                        imageUpload.value = '';
                        imageChoices.forEach((galleryChoice) => {
                            galleryChoice.classList.toggle('active', galleryChoice === choice);
                        });
                    });
                });

                imageUpload.addEventListener('change', () => {
                    if (imageUpload.files.length > 0) {
                        selectedImage.value = '';
                        selectedImageName.textContent = imageUpload.files[0].name;
                        imageChoices.forEach((choice) => choice.classList.remove('active'));
                    }
                });
            });
        </script>
    @endpush
@endonce
