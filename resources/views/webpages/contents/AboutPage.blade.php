@extends('webpages.layouts.Layout')

@section('Content')
  <link href="{{ asset('css/webpages/aboutpage.css') }}" rel="stylesheet">

  <div class="*banner">
    <div class="story">
      
      <div class="">
        <div class="grid grid-cols-3 py-5 flex">
          <div class="m-auto">
            <img src="../../../assets/images/29.jpg" alt="" />
          </div>
          <div class="m-auto">
            <img src="../../../assets/images/39.jpg" alt="" />
          </div>
          <div class="m-auto">
            <img src="../../../assets/images/43.jpg" alt="" />
          </div>
        </div>
        <p class="paragraph">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;การปฐมพยาบาลทางใจ
          คือการให้ความช่วยเหลือเบื้องต้นแก่ผู้ที่ประสบปัญหาทางจิตใจ เช่น
          ภาวะวิกฤต เหตุการณ์ร้ายแรง ปัญหาชีวิต โรคทางจิตเวช เป็นต้น
          โดยมีวัตถุประสงค์เพื่อลดความเครียด บรรเทาอาการทางอารมณ์
          และช่วยให้บุคคลเหล่านั้นสามารถปรับตัวและดำเนินชีวิตต่อไปได้
          การปฐมพยาบาลทางใจเป็นทักษะที่สำคัญที่ทุกคนควรเรียนรู้ไว้
          จะช่วยให้เราสามารถช่วยเหลือผู้ที่ประสบปัญหาทางจิตใจได้อย่างเหมาะสมและมีประสิทธิภาพ<br />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Look, Listen, Link
          เป็นหลักการในการปฐมพยาบาลทางใจ (Psychological First Aid)
          ที่ช่วยให้ผู้ประสบปัญหาทางจิตใจรู้สึกปลอดภัย ได้รับการปลอบโยน
          และสามารถปรับตัวและดำเนินชีวิตต่อไปได้
        </p>
      </div>

      <!-- look listen link -->
      <!-- look -->
      <div class="grid grid-cols-2">
        <div class="mt-3">
          <p class="paragraph">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Look หมายถึง การประเมินสถานการณ์
            ความปลอดภัยเป็นสิ่งสำคัญ
            ดังนั้นจึงควรประเมินสถานการณ์ก่อนให้การช่วยเหลือ เช่น
            สถานที่ปลอดภัยหรือไม่มีความเสี่ยงที่จะเกิดอันตรายหรือไม่<br />
            • ประเมินความปลอดภัยของสถานที่และสภาพแวดล้อม<br />
            • สังเกตพฤติกรรมและอาการของผู้ประสบปัญหา<br />
            • ประเมินความต้องการและความต้องการความช่วยเหลือของผู้ประสบปัญหา
          </p>
        </div>
        <div class="m-auto">
          <img src="../../../assets/images/skill-02.png" alt="" />
        </div>
      </div>

      <!-- listen -->
      <div class="grid grid-cols-2">
        <div class="m-auto">
          <img src="../../../assets/images/skill-16.png" alt="" />
        </div>
        <div class="mt-3">
          <p class="paragraph">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Listen หมายถึง การฟังอย่างตั้งใจ
            โดยไม่ตัดสินหรือวิพากษ์วิจารณ์
            ให้แสดงความเข้าใจและเห็นใจความรู้สึกของผู้ประสบปัญหา<br />
            • ให้ความสำคัญกับสิ่งที่ผู้ประสบปัญหาพูด<br />
            • ฟังโดยไม่ตัดสินหรือวิพากษ์วิจารณ์<br />
            • แสดงความเห็นอกเห็นใจและเข้าใจ
          </p>
        </div>
      </div>

      <!-- link -->
      <div class="grid grid-cols-2">
        <div class="mt-3">
          <p class="paragraph">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Link หมายถึง
            การเชื่อมโยงผู้ประสบปัญหากับแหล่งความช่วยเหลือเพิ่มเติม เช่น
            แนะนำแหล่งข้อมูลหรือบริการที่จำเป็น แนะนำให้พบแพทย์หรือผู้เชี่ยวชาญ<br />
            • แนะนำแหล่งข้อมูลหรือบริการที่จำเป็น<br />
            • แนะนำให้พบแพทย์หรือผู้เชี่ยวชาญ
          </p>
        </div>
        <div class="m-auto">
          <img src="../../../assets/images/skill-24.png" alt="" />
        </div>
      </div>

      <div class="">
        <!-- สาเหตุสุขภาพจิตใจ -->
        <div class="header text-center">
          <p class="paragraph !font-medium">สาเหตุที่ทำให้เกิดปัญหาทางสุขภาพจิตใจ</p>
        </div>
        <div class="grid grid-cols-2 mb-4">
          <p class="paragraph flex items-center">
            1. ปัจจัยด้านร่างกาย เช่น โรคทางกาย เช่น โรคสมอง โรคทางระบบประสาท
            โรคทางฮอร์โมน พันธุกรรม เป็นต้น
          </p>
          <div class="m-auto">
            <img src="../../../assets/images/stuff-20.png" alt="" />
          </div>
        </div>
        <div class="grid grid-cols-2 mb-4">
          <p class="paragraph flex items-center">
            2. ปัจจัยด้านจิตใจ เช่น ลักษณะบุคลิกภาพ การพัฒนาการทางอารมณ์และจิตใจ
            เหตุการณ์กระทบกระเทือนจิตใจ เป็นต้น
          </p>
          <div class="m-auto">
            <img src="../../../assets/images/stuff-22.png" alt="" />
          </div>
        </div>
        <div class="grid grid-cols-2 pb-4">
          <p class="paragraph flex items-center">
            3. ปัจจัยด้านสิ่งแวดล้อม เช่น สภาพสังคม วัฒนธรรม ครอบครัว เศรษฐกิจ
            เป็นต้น
          </p>
          <div class="m-auto">
            <img src="../../../assets/images/stuff-21.png" alt="" />
          </div>
        </div>

        <!-- ประโยชน์สุขภาพทางจิตใจ -->
        <div class="header text-center">
          <p class="paragraph !font-medium">ประโยชน์ของการปฐมพยาบาลทางใจ</p>
        </div>
        <div class="flex justify-center mb-4">
          <p class="paragraph w-fit">
            • ช่วยลดความเครียดและบรรเทาอาการทางอารมณ์ เช่น ความรู้สึกเศร้า
            วิตกกังวล กลัว หรือหวาดระแวง<br />
            • ช่วยให้ผู้ประสบปัญหารู้สึกปลอดภัยและได้รับการปลอบโยน<br />
            • ช่วยให้ผู้ประสบปัญหาสามารถปรับตัวและดำเนินชีวิตต่อไปได้
          </p>
        </div>
        <div class="header text-center">
          <p class="paragraph !font-medium">การปฐมพยาบาลทางใจสามารถช่วยได้ในกรณีต่อไปนี้</p>
        </div>
        <div class="flex justify-center pb-4">
          <p class="paragraph w-fit">
            • ภาวะวิกฤต เช่น ประสบอุบัติเหตุ ภัยธรรมชาติ หรือเหตุการณ์รุนแรง<br />
            • ปัญหาชีวิต เช่น ปัญหาด้านการเงิน ความสัมพันธ์ การทำงาน<br />
            • โรคทางจิตเวช เช่น โรคซึมเศร้า โรควิตกกังวล
            โรคเครียดหลังเหตุการณ์รุนแรง
          </p>
        </div>
        <div class="">
          <p class="paragraph">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;การปฐมพยาบาลทางใจสามารถทำได้โดยทุกคน
            ไม่จำเป็นต้องเป็นผู้เชี่ยวชาญด้านสุขภาพจิต
            เพียงแค่เรียนรู้หลักการง่ายๆ และฝึกฝนเป็นประจำ
            ก็จะสามารถช่วยเหลือผู้ที่ประสบปัญหาทางจิตใจได้อย่างเหมาะสมและมีประสิทธิภาพ
          </p>
          <div class="w-fit mx-auto">
            <img src="../../../assets/images/skill-09.png" alt="" />
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection