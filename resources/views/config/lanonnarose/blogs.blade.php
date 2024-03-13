@push('scripts')
<script>
    const bulletpointsEsContainer = document.getElementById('bulletpoints_es-container');
    const addBulletpointsEsButton = document.getElementById('add-bulletpoint_es');
    const removeBulletpointsEsButton = document.getElementById('remove-bulletpoint_es');
    const BulletpointsEsInput = document.getElementById('bulletpoints_es_span');
    let BulletpointsEsCount = 0;

    @if($editMode)

        const BulletpointsEsArray = {!! json_encode(explode('|', $blog->bulletpoints_es)) !!};
        console.log(BulletpointsEsArray)
        BulletpointsEsCount = BulletpointsEsArray.length;

        if (BulletpointsEsCount > 0) {
            for (let i = 0; i < BulletpointsEsArray.length; i++) {

                const skillDiv = document.createElement('div');
                skillDiv.classList.add('row'); // Add the Bootstrap 'row' class and custom margin class
                skillDiv.style.marginRight = '20px';
                skillDiv.style.marginBottom = '10px';
                // create the span instead of input 
                skillDiv.innerHTML = `
                <input type="text" class="form-control badge bg-indigo px-1 py-2" style="display: inline-block; width: 120px; height:36px;"name="bulletpoints_es[${i}]" value="${BulletpointsEsArray[i]}" readonly>
                `;

                bulletpointsEsContainer.appendChild(skillDiv);
            
            }
            removeBulletpointsEsButton.removeAttribute('disabled'); // Enable the button
        }
    @endif


    function addBulletpointsEs() {
        BulletpointsEsCount++;

        const skillDiv = document.createElement('div');
        const skillValue = BulletpointsEsInput.value;
        skillDiv.classList.add('row'); // Add the Bootstrap 'row' class and custom margin class
        skillDiv.style.marginRight = '20px';
        skillDiv.style.marginBottom = '10px';
        // create the span instead of input 
        skillDiv.innerHTML = `
            <input type="text" class="form-control badge bg-indigo px-1 py-2" style="display: inline-block; width: 120px; height:36px;" name="bulletpoints_es[${BulletpointsEsCount}]" value="${skillValue}" readonly>
        `;

        bulletpointsEsContainer.appendChild(skillDiv);
        BulletpointsEsInput.value = '';

        if (BulletpointsEsCount > 0) {
            removeBulletpointsEsButton.removeAttribute('disabled'); // Enable the button
        }
    }

    function removeBulletpointsEs() {
        if (BulletpointsEsCount > 0) {
            bulletpointsEsContainer.removeChild(bulletpointsEsContainer.lastChild);
            BulletpointsEsCount--;
        }

        if (BulletpointsEsCount === 0) {
            removeBulletpointsEsButton.setAttribute('disabled', 'disabled'); // Disable the button
        }
    }

    addBulletpointsEsButton.addEventListener('click', addBulletpointsEs);
    removeBulletpointsEsButton.addEventListener('click', removeBulletpointsEs);

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    const bulletpointsEnContainer = document.getElementById('bulletpoints_en-container');
    const addBulletpointsEnButton = document.getElementById('add-bulletpoint_en');
    const removeBulletpointsEnButton = document.getElementById('remove-bulletpoint_en');
    const BulletpointsEnInput = document.getElementById('bulletpoints_en_span');
    let BulletpointsEnCount = 0;

    @if($editMode)

        const BulletpointsEnArray = {!! json_encode(explode('|', $blog->bulletpoints_en)) !!};
        BulletpointsEnCount = BulletpointsEnArray.length;

        if (BulletpointsEnCount > 0) {
            for (let i = 0; i < BulletpointsEnArray.length; i++) {

                const skillDiv = document.createElement('div');
                skillDiv.classList.add('row'); // Add the Bootstrap 'row' class and custom margin class
                skillDiv.style.marginRight = '20px';
                skillDiv.style.marginBottom = '10px';
                // create the span instead of input 
                skillDiv.innerHTML = `
                <input type="text" class="form-control badge bg-indigo px-1 py-2" style="display: inline-block; width: 120px; height:36px;"name="bulletpoints_en[${i}]" value="${BulletpointsEnArray[i]}" readonly>
                `;

                bulletpointsEnContainer.appendChild(skillDiv);
            
            }
            removeBulletpointsEnButton.removeAttribute('disabled'); // Enable the button
        }
    @endif


    function addBulletpointsEn() {
        BulletpointsEnCount++;

        const skillDiv = document.createElement('div');
        const skillValue = BulletpointsEnInput.value;
        skillDiv.classList.add('row'); // Add the Bootstrap 'row' class and custom margin class
        skillDiv.style.marginRight = '20px';
        skillDiv.style.marginBottom = '10px';
        // create the span instead of input 
        skillDiv.innerHTML = `
            <input type="text" class="form-control badge bg-indigo px-1 py-2" style="display: inline-block; width: 120px; height:36px;" name="bulletpoints_en[${BulletpointsEnCount}]" value="${skillValue}" readonly>
        `;

        bulletpointsEnContainer.appendChild(skillDiv);
        BulletpointsEnInput.value = '';

        if (BulletpointsEnCount > 0) {
            removeBulletpointsEnButton.removeAttribute('disabled'); // Enable the button
        }
    }

    function removeBulletpointsEn() {
        if (BulletpointsEnCount > 0) {
            bulletpointsEnContainer.removeChild(bulletpointsEnContainer.lastChild);
            BulletpointsEnCount--;
        }

        if (BulletpointsEnCount === 0) {
            removeBulletpointsEnButton.setAttribute('disabled', 'disabled'); // Disable the button
        }
    }

    addBulletpointsEnButton.addEventListener('click', addBulletpointsEn);
    removeBulletpointsEnButton.addEventListener('click', removeBulletpointsEn);

</script>
@endpush