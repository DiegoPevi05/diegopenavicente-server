@push('scripts')
<script>
    const detailsEsContainer = document.getElementById('details-es-container');
    const addDetailEsButton = document.getElementById('add-detail-es');
    const removeDetailEsButton = document.getElementById('remove-detail-es');
    const detailsEsInput = document.getElementById('details_es_span');
    let detailEsCount = 0;

    @if($editMode)

        const detailsEsArray = {!! json_encode(explode('|', $experience->details_es)) !!};
        detailEsCount = detailsEsArray.length;

        if (detailEsCount > 0) {
            for (let i = 0; i < detailsEsArray.length; i++) {

                const detailEsDiv = document.createElement('div');
                detailEsDiv.classList.add('row', 'my-3'); // Add the Bootstrap 'row' class and custom margin class
                // create the span instead of input 
                detailEsDiv.innerHTML = `
                    <div class="col-12 d-flex flex-row my-0 py-0">
                        <label for="details_es[${i}]">${i+1}.-</label>
                        <input type="text" class="border border-0 my-0 py-0" name="details_es[${i}]" value="${detailsEsArray[i]}" readonly>
                    </div>
                `;

                detailsEsContainer.appendChild(detailEsDiv);
            
            }
            removeDetailEsButton.removeAttribute('disabled'); // Enable the button
        }
    @endif

    //modifyt addDetailEs so instead of adding input add a span with the value in the input detailEsInput and add the span to the container
    function addDetailEs() {
        detailEsCount++;

        const detailEsDiv = document.createElement('div');
        const detailEsValue = detailsEsInput.value;
        detailEsDiv.classList.add('row', 'my-3'); // Add the Bootstrap 'row' class and custom margin class
        // create the span instead of input 
        detailEsDiv.innerHTML = `
            <div class="col-12 d-flex flex-row my-0 py-0">
                <label for="details_es[${detailEsCount}]">${detailEsCount}.-</label>
                <input type="text" class="border border-0 my-0 py-0" name="details_es[${detailEsCount}]" value="${detailEsValue}" readonly>
            </div>
        `;

        detailsEsContainer.appendChild(detailEsDiv);
        detailsEsInput.value = '';

        if (detailEsCount > 0) {
            removeDetailEsButton.removeAttribute('disabled'); // Enable the button
        }
    }

    function removeDetailEs() {
        if (detailEsCount > 0) {
            detailsEsContainer.removeChild(detailsEsContainer.lastChild);
            detailEsCount--;

            if (detailEsCount === 0) {
                removeDetailEsButton.setAttribute('disabled', 'disabled'); // Disable the button
            }
        }
    }

    addDetailEsButton.addEventListener('click', addDetailEs);
    removeDetailEsButton.addEventListener('click', removeDetailEs);

      // ENGLISH DETAILS
      
    const detailsEnContainer = document.getElementById('details-en-container');
    const addDetailEnButton = document.getElementById('add-detail-en');
    const removeDetailEnButton = document.getElementById('remove-detail-en');
    const detailsEnInput = document.getElementById('details_en_span');
    let detailEnCount = 0;
    @if($editMode)
        const detailsEnArray = {!! json_encode(explode('|', $experience->details_en)) !!};
        console.log(detailsEnArray);
        detailEnCount = detailsEnArray.length;

        if (detailEnCount > 0) {
            for (let i = 0; i < detailsEnArray.length; i++) {

                const detailEnDiv = document.createElement('div');
                detailEnDiv.classList.add('row', 'my-3'); // Add the Bootstrap 'row' class and custom margin class
                // create the span instead of input 
                detailEnDiv.innerHTML = `
                    <div class="col-12 d-flex flex-row my-0 py-0">
                        <label for="details_en[${i}]">${i+1}.-</label>
                        <input type="text" class="border border-0 my-0 py-0" name="details_en[${i}]" value="${detailsEnArray[i]}" readonly>
                    </div>
                `;

                detailsEnContainer.appendChild(detailEnDiv);
            
            }
            removeDetailEnButton.removeAttribute('disabled'); // Enable the button
        }
    @endif

    function addDetailEn() {
        detailEnCount++;

        const detailEnDiv = document.createElement('div');
        const detailEnValue = detailsEnInput.value;
        detailEnDiv.classList.add('row', 'my-3'); // Add the Bootstrap 'row' class and custom margin class
        // create the span instead of input 
        detailEnDiv.innerHTML = `
            <div class="col-12 d-flex flex-row my-0 py-0">
                <label for="details_en[${detailEnCount}]">${detailEnCount}.-</label>
                <input type="text" class="border border-0 my-0 py-0" name="details_en[${detailEnCount}]" value="${detailEnValue}" readonly>
            </div>
        `;

        detailsEnContainer.appendChild(detailEnDiv);
        detailsEnInput.value = '';

        if (detailEnCount > 0) {
            removeDetailEnButton.removeAttribute('disabled'); // Enable the button
        }
    }

    function removeDetailEn() {
        if (detailEnCount > 0) {
            detailsEnContainer.removeChild(detailsEnContainer.lastChild);
            detailEnCount--;

            if (detailEnCount === 0) {
                removeDetailEnButton.setAttribute('disabled', 'disabled'); // Disable the button
            }
        }
    }

    addDetailEnButton.addEventListener('click', addDetailEn);
    removeDetailEnButton.addEventListener('click', removeDetailEn);

    // ITALIAN DETAILS

    const detailsItContainer = document.getElementById('details-it-container');
    const addDetailItButton = document.getElementById('add-detail-it');
    const removeDetailItButton = document.getElementById('remove-detail-it');
    const detailsItInput = document.getElementById('details_it_span');
    let detailItCount = 0;

    @if($editMode)
        const detailsItArray = {!! json_encode(explode('|', $experience->details_it)) !!};
        detailItCount = detailsItArray.length;

        if (detailItCount > 0) {
            for (let i = 0; i < detailsItArray.length; i++) {

                const detailItDiv = document.createElement('div');
                detailItDiv.classList.add('row', 'my-3'); // Add the Bootstrap 'row' class and custom margin class
                // create the span instead of input 
                detailItDiv.innerHTML = `
                    <div class="col-12 d-flex flex-row my-0 py-0">
                        <label for="details_it[${i}]">${i+1}.-</label>
                        <input type="text" class="border border-0 my-0 py-0" name="details_it[${i}]" value="${detailsItArray[i]}" readonly>
                    </div>
                `;

                detailsItContainer.appendChild(detailItDiv);
            
            }
            removeDetailItButton.removeAttribute('disabled'); // Enable the button
        }
    @endif

    function addDetailIt() {
        detailItCount++;

        const detailItDiv = document.createElement('div');
        const detailItValue = detailsItInput.value;
        detailItDiv.classList.add('row', 'my-3'); // Add the Bootstrap 'row' class and custom margin class
        // create the span instead of input 
        detailItDiv.innerHTML = `
            <div class="col-12 d-flex flex-row my-0 py-0">
                <label for="details_it[${detailItCount}]">${detailItCount}.-</label>
                <input type="text" class="border border-0 my-0 py-0" name="details_it[${detailItCount}]" value="${detailItValue}" readonly>
            </div>
        `;

        detailsItContainer.appendChild(detailItDiv);
        detailsItInput.value = '';

        if (detailItCount > 0) {
            removeDetailItButton.removeAttribute('disabled'); // Enable the button
        }
    }

    function removeDetailIt() {
        if (detailItCount > 0) {
            detailsItContainer.removeChild(detailsItContainer.lastChild);
            detailItCount--;

            if (detailItCount === 0) {
                removeDetailItButton.setAttribute('disabled', 'disabled'); // Disable the button
            }
        }
    }

    addDetailItButton.addEventListener('click', addDetailIt);
    removeDetailItButton.addEventListener('click', removeDetailIt);


</script>
@endpush