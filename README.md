# مشروع API لمعلومات مفيدة

---

## الوصف

هذا API يساعدك في جلب معلومات مفيدة وممتعة.

يمكن استخدامه في:
- تطبيقات تعليمية
- تطبيقات ترفيهية
- مشاريع بوتات أو مواقع

### طريقة الاستعمال :

*الاي بي هو : https://xc.page.gd/?i=0 *
يقوم تلقائيا بجلب اخر معلومة ومعها المعرف خاصتها النتيجة ستكون كلأتي :

```json
{
    "id":117,//المعرف
    "value_text":"النحل يستطيع التعرف على الوجوه البشرية"//الرساله
}
```

### ملاحضة :
يجب تحميل ملف lib.php من المستودع
لتجنب حماية التيست كوكي الاني الاستضافة اللي انا عليها لها حماية corp
لذا اوفر سكربت يجاوز لك ذالك

## الاستخدام السكربت :
من اي مكان قم بالاتي :

```php
require "lib.php";
echo get_api("اي api تريده".$_GET["i"]);
```

# تنبيه :

* لقد تركت مثلا كاملا عن كيفية استخدام الاي بي

# (شرح العرض التقديمي) :
## JAVA SCRIPT :

```js
const Next = document.getElementById('Next');
const last = document.getElementById('last');
const relod = document.getElementById('relod');
const value_text = document.getElementById('value_text');

let num = 0; //الاي دي المستخدم في الطلب
let loading = false;

async function getapi() {
    if (loading) return;
    loading = true;

    value_text.value = "جاري التحميل ...";

    try {
        const res = await fetch("api.php?i=" + num); //ارسال العنوان لملف الطلب
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


///================================> اعادة ضبط المعلومات
relod.onclick = function () {
    num = 0;//لاتزد الاي دي سيزيد وحده
    getapi();
};

///================================> المعلومة التاليه
Next.onclick = function () {
    getapi();
};

///================================> المعلومة السابقة
last.onclick = function () {
    if (num > 0) num-=2;//لازم -2 لجلب المعلومة السابقة
    getapi();
};

let typingInterval = null;


/////----------------------------> انميشن الكتابة
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
```

## php (ملف الطلب):
```php
require "lib.php"; //ربط المكتبة المضمنة
echo get_api("https://xc.page.gd/?i=".$_GET["i"]); //طلب البيانات من خلال الاي دي القادم من جافا سكربت
```
