@push('scripts')
<script>
    const skillsContainer = document.getElementById('keywords-container');
    const addSkillButton = document.getElementById('add-keyword');
    const removeSkillButton = document.getElementById('remove-keyword');
    const skillInput = document.getElementById('keywords_span');
    let skillCount = 0;

    @if($editMode)

        const skillsArray = {!! json_encode(explode('|', $skill->keywords)) !!};
        skillCount = skillsArray.length;

        if (skillCount > 0) {
            for (let i = 0; i < skillsArray.length; i++) {

                const skillDiv = document.createElement('div');
                skillDiv.classList.add('row'); // Add the Bootstrap 'row' class and custom margin class
                skillDiv.style.marginRight = '20px';
                skillDiv.style.marginBottom = '10px';
                // create the span instead of input 
                skillDiv.innerHTML = `
                <input type="text" class="form-control badge bg-indigo px-1 py-2" style="display: inline-block; width: 120px; height:36px;"name="keywords[${i}]" value="${skillsArray[i]}" readonly>
                `;

                skillsContainer.appendChild(skillDiv);
            
            }
            removeSkillButton.removeAttribute('disabled'); // Enable the button
        }
    @endif


    function addSkill() {
        skillCount++;

        const skillDiv = document.createElement('div');
        const skillValue = skillInput.value;
        skillDiv.classList.add('row'); // Add the Bootstrap 'row' class and custom margin class
        skillDiv.style.marginRight = '20px';
        skillDiv.style.marginBottom = '10px';
        // create the span instead of input 
        skillDiv.innerHTML = `
            <input type="text" class="form-control badge bg-indigo px-1 py-2" style="display: inline-block; width: 120px; height:36px;" name="keywords[${skillCount}]" value="${skillValue}" readonly>
        `;

        skillsContainer.appendChild(skillDiv);
        skillInput.value = '';

        if (skillCount > 0) {
            removeSkillButton.removeAttribute('disabled'); // Enable the button
        }
    }

    function removeSkill() {
        if (skillCount > 0) {
            skillsContainer.removeChild(skillsContainer.lastChild);
            skillCount--;
        }

        if (skillCount === 0) {
            removeSkillButton.setAttribute('disabled', 'disabled'); // Disable the button
        }
    }

    addSkillButton.addEventListener('click', addSkill);
    removeSkillButton.addEventListener('click', removeSkill);

</script>
@endpush