@push('scripts')
<script>
const skillsListOptions = document.getElementById('skills-list-options');
const skillsContainer = document.getElementById('skills-container');
const titleInput = document.getElementById('skill-input-title');
let counterSkills = 0;

@if($editMode)
    const skillsArray = {!! json_encode($project->skills->pluck('title')->toArray()) !!};
    const skillsIdArray = {!! json_encode($project->skills->pluck('id')->toArray()) !!};
    counterSkills = skillsArray.length;

    if (counterSkills > 0) {
        for (let i = 0; i < skillsArray.length; i++) {
            addSkillToContainer(skillsIdArray[i], skillsArray[i]);
        }
    }
@endif

async function fetchSkills(event) {
    event.preventDefault();
    const title = titleInput.value.trim();

    if (title === '') {
        skillsListOptions.innerHTML = '';
        return;
    }
    
    try {
        // Fetch skills data
        const response = await fetch(`{{env('BACKEND_URL')}}/search-skills?name=${encodeURIComponent(title)}`);
        const data = await response.json();
        
        // Clear previous skills
        skillsListOptions.innerHTML = '';
        
        // Display skills as options
        data.forEach(skill => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item skills-list-item py-1 cursor-pointer';
            listItem.textContent = skill.title;
            listItem.addEventListener('click', () => {
                addSkillToContainer(skill.id, skill.title);
            });
            skillsListOptions.appendChild(listItem);
        });
    } catch (error) {
        console.error('Error fetching skills:', error);
    }
}

function addSkillToContainer(skillId, skillName) {
    // Create div to contain badge and delete button
    const skillDiv = document.createElement('div');
    skillDiv.className = 'badge bg-indigo d-inline-flex align-items-center m-1 col-2 py-2 justify-content-around rounded-pill';

    // Create badge element
    const badge = document.createElement('span');
    badge.textContent = skillName;
    
    // Create delete button
    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'btn btn-sm btn-info rounded-circle ms-1';
    deleteButton.textContent = 'x';
    deleteButton.style.width = '1.5rem';
    deleteButton.style.height = '1.5rem';
    deleteButton.style.display = 'flex';
    deleteButton.style.alignItems = 'center';
    deleteButton.style.justifyContent = 'center';
    deleteButton.style.padding = '0';
    deleteButton.style.fontSize = '1rem';

    // Event listener to remove the skill when the delete button is clicked
    deleteButton.addEventListener('click', () => {
        skillDiv.remove();
        updateSkillIndexes();
    });

    // Append badge and delete button to the skillDiv
    skillDiv.appendChild(badge);
    skillDiv.appendChild(deleteButton);

    // Append skillDiv to the skills container
    skillsContainer.appendChild(skillDiv);

    // Create hidden input element to store skill id
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = `skills[${counterSkills}]`; // Assigning reference using counter variable
    input.value = skillId;
    
    // Append input to skillDiv
    skillDiv.appendChild(input);

    // Increment counterSkills for the next input
    counterSkills++;
}

function updateSkillIndexes() {
    // Select all input elements with name 'skills[]'
    const inputs = document.querySelectorAll('input[name^="skills"]');
    // Loop through each input element and update its name attribute
    inputs.forEach((input, index) => {
        input.name = `skills[${index}]`;
    });

    counterSkills = inputs.length;
}

</script>
@endpush