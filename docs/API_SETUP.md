# API Setup Guide - WaverPro

Complete guide for configuring Google Drive and WhatsApp integrations.

---

## **Overview**

WaverPro uses webhooks to integrate with:
- **Google Drive** - Automatic PDF backup
- **WhatsApp Business API** - Automated messages

Both integrations are configured via **Zapier** or **Make.com**.

---

## **Google Drive Integration**

### **What it does:**
- Automatically uploads signed waivers to Google Drive
- Organizes by date and activity type
- Creates backup structure

### **Setup Steps:**

#### **1. Create Zapier Account**
- Go to: https://zapier.com/sign-up
- Choose "Professional" plan (R$ 100/month for unlimited Zaps)

#### **2. Create New Zap**

**Trigger:**
- App: **Webhooks by Zapier**
- Event: **Catch Hook**
- Copy the webhook URL (e.g., `https://hooks.zapier.com/hooks/catch/123456/abcdef/`)

**Action:**
- App: **Google Drive**
- Event: **Upload File**
- Connect your Google Drive account
- Configure:
  - **Folder:** `/WaverPro-Backups/{{student_name}}`
  - **File:** Use URL from webhook payload
  - **Filename:** `{{student_name}}_{{activity_type}}_{{sign_date}}.pdf`

#### **3. Test the Zap**

Send test webhook:
```bash
curl -X POST https://hooks.zapier.com/hooks/catch/123456/abcdef/ \
  -H "Content-Type: application/json" \
  -d '{
    "student_name": "Test User",
    "activity_type": "Kitesurf",
    "sign_date": "2024-09-30",
    "pdf_url": "https://example.com/test.pdf",
    "school_id": "test-school"
  }'
```

#### **4. Add Webhook to WaverPro**

1. WordPress Admin → **WaverPro → Configurações**
2. **Google Drive Webhook URL:** Paste the Zapier webhook URL
3. **Save Settings**

---

## **WhatsApp Integration**

### **What it does:**
- Sends waiver link to students
- Sends confirmation after signing
- Sends reminders for pending waivers

### **Setup Steps:**

#### **1. Choose WhatsApp Provider**

**Option A: 360Dialog** (Recommended for Brazil)
- Website: https://www.360dialog.com/
- Cost: ~R$ 100-200/month
- Best for: Brazilian market

**Option B: Twilio**
- Website: https://www.twilio.com/whatsapp
- Cost: ~$20-50/month
- Best for: International

#### **2. Get WhatsApp Business API Access**

**For 360Dialog:**
1. Sign up at 360dialog.com
2. Verify your business
3. Get API credentials
4. Create message templates

**For Twilio:**
1. Create Twilio account
2. Enable WhatsApp on your account
3. Configure WhatsApp Business Profile
4. Get API credentials

#### **3. Create Zapier Automation**

**Trigger:**
- App: **Webhooks by Zapier**
- Event: **Catch Hook**
- Copy webhook URL

**Action:**
- App: **WhatsApp by 360Dialog** or **Twilio**
- Event: **Send Message**
- Configure:
  - **To:** `{{phone}}` (from webhook)
  - **Message:** Use template below

**Message Templates:**

**Waiver Request (Portuguese):**
```
🌊 Olá {{name}}!

Você precisa assinar o termo de responsabilidade para sua aula de {{activity}} em {{class_date}}.

📋 Link: {{waiver_url}}
⏰ Prazo: 24 horas antes da aula

Qualquer dúvida, responda esta mensagem!

🏄‍♂️ {{school_name}}
```

**Confirmation (Portuguese):**
```
✅ Termo assinado com sucesso!

📄 Seu documento foi registrado
📅 Aula confirmada para {{class_date}}
📍 Local: {{school_address}}

Nos vemos na água! 🏄‍♂️
```

#### **4. Add Webhook to WaverPro**

1. WordPress Admin → **WaverPro → Configurações**
2. **WhatsApp Webhook URL:** Paste the Zapier webhook URL
3. **Save Settings**

---

## **Testing the Integration**

### **Test Google Drive:**
1. Submit a test waiver form
2. Check Google Drive folder
3. Verify PDF was uploaded
4. Check filename format

### **Test WhatsApp:**
1. Use your own phone number in test form
2. Submit waiver
3. Verify you receive WhatsApp message
4. Check message formatting

---

## **Troubleshooting**

### **Google Drive not uploading:**
- Check Zapier task history for errors
- Verify Google Drive permissions
- Check PDF URL is accessible
- Verify folder structure exists

### **WhatsApp not sending:**
- Verify phone number format (+55XXXXXXXXXXX)
- Check WhatsApp Business API balance
- Verify message template is approved
- Check Zapier webhook logs

### **Webhook not triggering:**
- Verify webhook URL is correct in WaverPro settings
- Check WordPress error logs
- Test webhook manually with curl
- Verify internet connectivity on hosting

---

## **Cost Summary**

| Service | Monthly Cost | Annual Cost |
|---------|-------------|-------------|
| Zapier Professional | R$ 100 | R$ 1,200 |
| 360Dialog WhatsApp | R$ 150 | R$ 1,800 |
| Google Drive (15GB free) | R$ 0 | R$ 0 |
| **TOTAL** | **R$ 250** | **R$ 3,000** |

**Client investment:** R$ 250/month for full automation

**Your one-time fee:** R$ 2,200 (setup + configuration)

---

##  **Support**

For integration issues:
- Documentation: https://github.com/emilly-kelda/waverpro

---

**Next:** [DEPLOYMENT.md](DEPLOYMENT.md) - Deploy to client hosting