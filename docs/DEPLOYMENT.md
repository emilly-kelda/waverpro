# WaverPro Deployment Guide

Complete step-by-step guide for deploying WaverPro to a client's WordPress site.

**Time estimate:** 4-5 hours total

---

## **Pre-Deployment Checklist**

Before starting deployment, ensure you have:

- [ ] Client's WordPress admin credentials
- [ ] Client's hosting control panel access (cPanel/Plesk)
- [ ] Gravity Forms Pro license key
- [ ] Client's Google Drive account access
- [ ] Client's WhatsApp Business API credentials
- [ ] Client's logo file (PNG, min 300x100px)
- [ ] Client's brand colors (hex codes)

---

## **Deployment Timeline**

### **Hour 1: WordPress Setup**
- Install required plugins
- Configure WaverPro settings
- Set up brand customization

### **Hour 2: Form Creation**
- Create waiver form in Gravity Forms
- Configure PDF template
- Set up multilingual versions

### **Hour 3: API Integration**
- Configure Google Drive webhook
- Set up WhatsApp automation
- Test integrations end-to-end

### **Hour 4: Training & Handoff**
- Train client staff (Zoom session)
- Provide documentation
- Answer questions
- Collect payment

---

## **Step-by-Step Deployment**

### **Phase 1: WordPress Preparation (30 minutes)**

#### **1. Verify System Requirements**

**Check PHP version:**
```php
<?php phpinfo(); ?>
```
Minimum: PHP 7.4

**Check WordPress version:**
- Dashboard → Updates
- Minimum: WordPress 6.0

**Check SSL Certificate:**
- URL must have HTTPS (padlock in browser)
- If missing, install SSL via cPanel/Let's Encrypt

#### **2. Install Required Plugins**

**Gravity Forms Pro:**
```
1. Download from gravityforms.com (client's license)
2. Plugins → Add New → Upload Plugin
3. Activate
4. Forms → Settings → Enter license key
```

**Gravity Forms Add-ons:**
```
Forms → Settings → Add-Ons → Install:
- Signature Add-on
- WebHooks Add-on
```

**Gravity PDF:**
```
Plugins → Add New → Search "Gravity PDF"
Install & Activate (free version)
```

**WPML or Polylang (optional):**
```
If client needs multilingual:
- Purchase WPML license OR
- Install Polylang (free) from WordPress.org
```

#### **3. Install WaverPro Plugin**

**Upload plugin:**
```
1. Download waverpro-core.zip from GitHub
2. Plugins → Add New → Upload Plugin
3. Choose file → Install
4. Activate WaverPro Core
```

**Verify installation:**
```
Check for "WaverPro" menu in WordPress admin sidebar
```

---

### **Phase 2: WaverPro Configuration (45 minutes)**

#### **4. Configure Basic Settings**

**Navigate to WaverPro → Configurações**

**School ID:**
```
Format: escola-[city]-[name]
Example: escola-cumbuco-waves
```

**Primary Color:**
```
Use client's brand color (hex code)
Example: #0066cc
```

**Save settings** (bottom of page)

#### **5. Create Waiver Form**

**Forms → New Form → Blank Form**

**Form Settings:**
- Title: `Termo de Responsabilidade - [Activity]`
- Description: `Por favor, preencha todos os campos para participar das atividades.`
- Form CSS Class: `waverpro-waiver`

**Add Fields (in order):**

1. **Name**
   - Type: Single Line Text
   - Label: `Nome Completo`
   - Required: ✅

2. **Email**
   - Type: Email
   - Label: `E-mail`
   - Required: ✅

3. **Phone**
   - Type: Phone
   - Label: `WhatsApp`
   - Format: International
   - Required: ✅

4. **Date of Birth**
   - Type: Date
   - Label: `Data de Nascimento`
   - Date Format: dd/mm/yyyy
   - Required: ✅

5. **CPF/Passport**
   - Type: Single Line Text
   - Label: `CPF ou Passaporte`
   - Required: ✅

6. **Activity Type**
   - Type: Drop Down
   - Label: `Atividade`
   - Choices:
     - Kitesurf
     - Windsurf
     - Wing Foil
     - Surf
     - SUP
   - Required: ✅

7. **Class Date**
   - Type: Date
   - Label: `Data da Aula`
   - Date Format: dd/mm/yyyy
   - Required: ✅

8. **Medical Conditions**
   - Type: Paragraph Text
   - Label: `Condições Médicas / Alergias`
   - Description: `Informe qualquer condição médica relevante para sua segurança`
   - Required: ❌

9. **Emergency Contact Name**
   - Type: Single Line Text
   - Label: `Contato de Emergência (Nome)`
   - Required: ✅

10. **Emergency Contact Phone**
    - Type: Phone
    - Label: `Contato de Emergência (Telefone)`
    - Required: ✅

11. **LGPD Consent**
    - Type: Checkbox
    - Label: `Consentimento LGPD`
    - Choices:
```
      Autorizo o tratamento dos meus dados pessoais conforme a LGPD 
      (Lei nº 13.709/2018) para fins de emissão de termo de 
      responsabilidade, controle de segurança e comunicação sobre 
      atividades da escola.
```
    - Required: ✅

12. **Signature**
    - Type: Signature
    - Label: `Assinatura Digital`
    - Description: `Assine com seu dedo ou mouse`
    - Required: ✅
    - Pen Size: Medium
    - Pen Color: Black
    - Background Color: White

**Form Settings:**
- Confirmation → Text: `✅ Termo assinado com sucesso! Você receberá uma confirmação via WhatsApp.`
- Save Form

#### **6. Configure PDF Template**

**Forms → PDF → Add New**

**Template Settings:**
- Name: `Termo Assinado - [Activity]`
- Template: `Zadani` or `Rubix`
- Paper Size: A4
- Format: Standard
- Filename: `termo_{student_name}_{date}.pdf`

**Custom Template (Advanced):**
```
1. Copy content from templates/pdf-templates/waiver-template.php
2. Forms → PDF → Template → Custom
3. Paste template code
4. Adjust styling to match school branding
```

**Map Form Fields:**
```
Ensure all form fields appear in PDF preview
Test PDF generation with sample data
```

---

### **Phase 3: API Integration (60 minutes)**

#### **7. Set Up Google Drive Backup**

**Create Zapier Account:**
```
1. Go to zapier.com
2. Sign up (use client's email if possible)
3. Choose Professional plan (R$ 100/month)
```

**Create Zap:**
```
Trigger: Webhooks by Zapier → Catch Hook
  - Copy webhook URL
  
Action: Google Drive → Upload File
  - Connect client's Google Drive
  - Folder: /WaverPro-Backups/{{student_name}}/
  - File URL: {{pdf_url}}
  - Filename: {{student_name}}_{{activity}}_{{date}}.pdf
  
Test: Send test webhook → verify file appears in Drive
Turn On: Activate the Zap
```

**Add to WaverPro:**
```
WaverPro → Configurações
Google Drive Webhook URL: [paste Zapier webhook]
Save
```

#### **8. Set Up WhatsApp Automation**

**Create WhatsApp API Account:**
```
Option A: 360Dialog (recommended for Brazil)
1. Go to 360dialog.com
2. Sign up for client
3. Verify business
4. Get API credentials

Option B: Twilio
1. Go to twilio.com
2. Enable WhatsApp
3. Configure business profile
```

**Create WhatsApp Zap:**
```
Trigger: Webhooks by Zapier → Catch Hook
  - Copy webhook URL

Action: WhatsApp (360Dialog or Twilio) → Send Message
  - To: {{phone}}
  - Message:
```
    ✅ Termo assinado com sucesso!
    
    📄 Seu documento foi registrado
    📅 Aula confirmada para {{class_date}}
    
    Nos vemos na água! 🏄‍♂️
```
    
Test: Send to your phone number
Turn On: Activate Zap
```

**Add to WaverPro:**
```
WaverPro → Configurações
WhatsApp Webhook URL: [paste Zapier webhook]
Save
```

---

### **Phase 4: Testing & Validation (30 minutes)**

#### **9. End-to-End Testing**

**Test Scenario:**
```
1. Open waiver form in incognito browser
2. Fill all fields with test data
3. Sign with mouse/finger
4. Submit form
5. Verify:
   ✅ Confirmation message appears
   ✅ PDF generated (check Gravity Forms entries)
   ✅ PDF uploaded to Google Drive
   ✅ WhatsApp message received
   ✅ All data appears correctly in PDF
```

**Medical Alert Test:**
```
1. Submit form with medical conditions filled
2. Check PDF shows medical alert prominently
3. Verify staff can see alert in dashboard
```

**Mobile Test:**
```
1. Open form on mobile phone
2. Complete entire flow
3. Verify signature works on touch screen
4. Check PDF formatting on mobile
```

---

### **Phase 5: Client Training (60 minutes)**

#### **10. Training Session (Zoom)**

**Topics to cover:**

**Dashboard Navigation (10 min)**
```
- Show WaverPro dashboard
- Explain statistics cards
- Navigate to form entries
- Search for specific students
```

**Daily Workflow (15 min)**
```
- Check pending waivers
- Review medical alerts
- Export reports for legal compliance
- Handle edge cases (missing signatures, etc.)
```

**Bulk Operations (15 min)**
```
- Prepare CSV with student list
- Upload and send mass waivers
- Track delivery status
- Follow up on non-responses
```

**Settings Management (10 min)**
```
- Update school information
- Change brand colors
- Modify webhook URLs if needed
- Where to find support
```

**Q&A (10 min)**
```
- Answer client questions
- Address concerns
- Provide contact information
```

#### **11. Documentation Handoff**

**Provide to client:**
```
✅ PDF: WaverPro User Manual
✅ Video: Quick Start Guide
✅ PDF: Emergency Procedures
✅ Contact card: Your support info
```

---

## **Payment Collection**

### **12. Invoice & Payment**

**Invoice includes:**
```
WaverPro Digital Waiver System Setup
- WordPress plugin installation
- Gravity Forms configuration
- PDF template customization
- Google Drive integration
- WhatsApp automation
- Staff training (2 hours)
- 30-day support

Total: R$ 2.200,00
```

**Payment methods:**
```
- PIX (preferred)
- Bank transfer
- Credit card (if you have payment processor)
```

**30-Day Support:**
```
Included:
- Bug fixes
- Configuration adjustments
- Email support (24-48h response)

Not included:
- New features
- Additional forms
- Design changes
```

---

## **Post-Deployment**

### **13. Follow-up Schedule**

**Day 3:** Check-in email
```
Subject: Como está indo o WaverPro?

Olá [Client Name],

Como estão as primeiras experiências com o WaverPro?
Alguma dúvida ou ajuste necessário?

Abraço,
Emilly
```

**Day 7:** Usage review
```
- Check dashboard metrics
- Review any issues
- Offer quick adjustment if needed
```

**Day 30:** Support period ending
```
- Final check-in
- Offer extended support package (R$ 200/month)
- Request testimonial/referral
```

---

## **Success Metrics**

**Track for each deployment:**
```
- Time to complete: ____ hours
- Client satisfaction: __/10
- Technical issues: Yes/No
- Referral given: Yes/No
- Extended support sold: Yes/No
```

---

## **Common Issues & Solutions**

### **Issue: Signature field not appearing**
```
Solution:
1. Verify Gravity Forms Signature Add-on is installed
2. Check field type is "Signature"
3. Clear WordPress cache
4. Test in different browser
```

### **Issue: PDF not generating**
```
Solution:
1. Check PHP memory limit (256MB minimum)
2. Verify Gravity PDF is activated
3. Check file permissions on /wp-content/uploads/
4. Review WordPress error logs
```

### **Issue: WhatsApp not sending**
```
Solution:
1. Verify webhook URL is correct
2. Check phone number format (+5511999999999)
3. Verify Zapier task history for errors
4. Test webhook manually with curl
```

### **Issue: Google Drive not uploading**
```
Solution:
1. Check Zapier connection to Google Drive
2. Verify folder permissions
3. Check PDF URL is publicly accessible
4. Review Zapier task history
```

---

## **Deployment Checklist**

**Pre-Deployment:**
- [ ] Gathered all client credentials
- [ ] Downloaded required plugins
- [ ] Prepared training materials

**WordPress Setup:**
- [ ] Verified system requirements
- [ ] Installed Gravity Forms Pro
- [ ] Installed WaverPro plugin
- [ ] Configured basic settings

**Form Configuration:**
- [ ] Created waiver form
- [ ] Set up PDF template
- [ ] Tested form submission
- [ ] Verified PDF generation

**API Integration:**
- [ ] Configured Google Drive webhook
- [ ] Set up WhatsApp automation
- [ ] Tested both integrations
- [ ] Verified end-to-end flow

**Client Training:**
- [ ] Conducted training session
- [ ] Provided documentation
- [ ] Answered all questions
- [ ] Scheduled follow-up

**Payment & Handoff:**
- [ ] Sent invoice
- [ ] Received payment
- [ ] Provided support contact info
- [ ] Marked project as complete

---

## **Support**

For deployment issues:
- **GitHub Issues:** github.com/emilly-kelda/waverpro/issues

---

**Deployment complete!**

Save this checklist for each client deployment to ensure consistency and quality.