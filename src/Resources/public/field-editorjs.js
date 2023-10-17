document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll("textarea.ea-editorjs-content").forEach((textarea) => {
        let editorjsConfig = {
            holder: `${textarea.id}-editor`,
        };

        const customEditorjsConfig = JSON.parse(textarea.getAttribute('data-editorjs-config'));
        if(null !== customEditorjsConfig) {
            editorjsConfig = merge(customEditorjsConfig, editorjsConfig);
        }

        const json = textarea.value;
        if (null !== json && "" !== json) {
            editorjsConfig.data = JSON.parse(json);
        }

        if(Object.hasOwn(editorjsConfig, 'tools')) {
            for (const [tool] of Object.entries(editorjsConfig.tools)) {
                editorjsConfig.tools[tool].class = eval(editorjsConfig.tools[tool].class);
            }
        }

        console.log(editorjsConfig);

        const editor = new EditorJS(editorjsConfig);

        document.addEventListener('ea.form.submit', (formEvent) => {
            editor
                .save()
                .then((json) => {
                    textarea.value = JSON.stringify(json);
                })
                .catch((error) => {
                    console.error("Saving failed: ", error);
                });
        });
    });
});

// copied from https://gist.github.com/ahtcx/0cd94e62691f539160b32ecda18af3d6?permalink_comment_id=3889214#gistcomment-3889214
function merge(source, target) {
    for (const [key, val] of Object.entries(source)) {
        if (val !== null && typeof val === `object`) {
            target[key] ??=new val.__proto__.constructor();
            merge(val, target[key]);
        } else {
            target[key] = val;
        }
    }
    return target;
}
