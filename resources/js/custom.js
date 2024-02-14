import {useForm} from "@inertiajs/vue3";
const globalForm = useForm({});

document.addEventListener('click', function(e){

    if (e.target.classList.contains('destroyBtn') || e.target.parentElement.classList.contains('destroyBtn') || e.target.parentElement.parentElement.classList.contains('destroyBtn'))
    {
        let destroyBtn = null;

        if (e.target.classList.contains('destroyBtn'))
            destroyBtn = e.target;
        else if (e.target.parentElement.classList.contains('destroyBtn'))
            destroyBtn = e.target.parentElement;
        else if (e.target.parentElement.parentElement.classList.contains('destroyBtn'))
            destroyBtn = e.target.parentElement.parentElement;

        if (destroyBtn.dataset.url && confirm("Delete Item?"))
        {
            globalForm.delete(destroyBtn.dataset.url, {
                onFinish: () => globalForm.reset(),
            });
        }
    }

});
