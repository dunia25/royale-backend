function getSkinType() {
    let morningFeel = document.querySelector('input[name="morningFeel"]:checked')?.value;
    let sunReaction = document.querySelector('input[name="sunReaction"]:checked')?.value;
    let poresSize = document.querySelector('input[name="poresSize"]:checked')?.value;
    let winterDryness = document.querySelector('input[name="winterDryness"]:checked')?.value;
    let afterShower = document.querySelector('input[name="afterShower"]:checked')?.value;
    let skincareRoutine = document.querySelector('input[name="skincareRoutine"]:checked')?.value;
    let productSensitivity = document.querySelector('input[name="productSensitivity"]:checked')?.value;
    let moisturizerAbsorption = document.querySelector('input[name="moisturizerAbsorption"]:checked')?.value;
    let coldReaction = document.querySelector('input[name="coldReaction"]:checked')?.value;
    let heatReaction = document.querySelector('input[name="heatReaction"]:checked')?.value;

    // إنشاء نتيجة تحليل البشرة
   let resultText = "بناءً على إجاباتكِ، ";

    if (morningFeel === "جافة" && poresSize === "صغيرة") resultText += "جافة وتحتاج إلى ترطيب مكثف.";
    else if (morningFeel === "دهنية" && poresSize === "كبيرة") resultText += "دهنية وتحتاج إلى تنظيف مستمر.";
    else if (morningFeel === "مختلطة" && poresSize === "متوسطة") resultText += "مختلطة وتحتاج إلى توازن في العناية.";
    else if (morningFeel === "عادية") resultText += "عادية ومتوازنة.";

    if (winterDryness === "نعم") resultText += " احرصي على استخدام كريم مرطب غني بالزيوت الطبيعية.";
    if (afterShower === "جافة") resultText += " يفضل تطبيق زيت الأرجان بعد الاستحمام للحفاظ على الترطيب.";
    if (skincareRoutine) resultText += ` وأهم خطوة في روتين العناية لديكِ هي ${skincareRoutine}.`;
    if (productSensitivity === "نعم") resultText += "منتجات لطيفة وخالية من العطور لتجنب التهيج. ";
    if (moisturizerAbsorption === "بطيء") resultText += "تركيبات خفيفة تمتصها البشرة بسهولة دون ترك أثر دهني. ";
    if (coldReaction === "تجف بسرعة") resultText += "استخدام زيوت طبيعية مثل زيت الأرغان في الشتاء للحفاظ على الترطيب. ";
    if (heatReaction === "تعرق بشكل زائد") resultText += "منتجات خفيفة وخالية من الزيوت لضبط إفراز الدهون في الطقس الحار.";

     // عرض النتيجة داخل الصفحة
  document.getElementById("skinResultText").textContent = resultText;
    document.getElementById("result").classList.remove("hidden");
}