const Next = document.getElementById('Next');
const last = document.getElementById('last');
const relod = document.getElementById('relod');
const value_text = document.getElementById('value_text');

let num = 0;
let loading = false;

async function getapi() {
    if (loading) return;
    loading = true;

    value_text.value = "جاري التحميل ...";

    try {
        const res = await fetch("api.php?i=" + num);
        const data = await res.json();

        if (data.value_text && data.id !== undefined) {
            num = data.id;
            relod.classList.add('hidden');
        
            typeText(value_text, data.value_text);
        }else {
            relod.classList.remove('hidden');
        }

    } catch (err) {
        value_text.value = "حدث خطأ ما يرجى الإعادة من الأول";
    } finally {
        loading = false;
    }
}

relod.onclick = function () {
    num = 0;
    getapi();
};

Next.onclick = function () {
    getapi();
};

last.onclick = function () {
    if (num > 0) num-=2;
    getapi();
};

let typingInterval = null;

function typeText(element, text, speed = 30) {

    if (typingInterval) {
        clearInterval(typingInterval);
        typingInterval = null;
    }

    element.value = "";
    let i = 0;

    typingInterval = setInterval(() => {
        element.value += text[i];
        i++;

        if (i >= text.length) {
            clearInterval(typingInterval);
            typingInterval = null;
        }
    }, speed);
}