# WaverPro - Digital Waiver System for Watersports Schools

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![WordPress](https://img.shields.io/badge/WordPress-6.0+-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-7.4+-purple.svg)](https://www.php.net/)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](http://makeapullrequest.com)

Enterprise-grade digital waiver management system specifically built for Brazilian watersports schools. Features complete LGPD compliance, WhatsApp automation, multilingual support, and automated Google Drive backups.


## **The Problem**

Watersports schools in Brazil face critical challenges:
- **Legal liability risks** from lost or incomplete paper waivers
- **Time-consuming manual check-ins** (15+ hours/week on paperwork)
- **LGPD compliance issues** with unorganized personal data storage
- **International tourists** requiring multilingual documentation
- **Lost documents** leading to potential legal exposure

**One lawsuit can cost R$ 50,000+. WaverPro eliminates this risk.**


## **Features**

### **Legal & Compliance**
-  **Digital signatures** with cryptographic validation
-  **LGPD compliant** audit trails (IP, timestamp, device)
-  **Tamper-proof records** with SHA-256 hashing
-  **Legal privacy policy** templates included
-  **5-year data retention** as per Brazilian liability law

### **Automation & Integration**
-  **WhatsApp automation** - Send waivers via WhatsApp with one click
-  **Google Drive backup** - Every signed waiver automatically stored
-  **Bulk operations** - Send 50+ waivers simultaneously
-  **Email notifications** - Automatic confirmations
-  **Zapier/Make.com** integration ready

### **Multilingual Support**
-  **Portuguese** (primary)
-  **English** (international tourists)
-  **Spanish** (Latin American visitors)
-  **French** (European tourists)

### **Admin Dashboard**
-  **Real-time statistics** - Daily check-ins, pending waivers, medical alerts
-  **Student search** - Instant lookup by name/phone/email
-  **Medical alerts** - Prominently displayed safety warnings
-  **CSV exports** - For legal audits and reporting
-  **Mobile responsive** - Manage from any device


## **Target Market**

Built specifically for Brazilian watersports schools offering:
-  **Kitesurfing**
-  **Windsurfing**
-  **Wing Foiling**
-  **Surfing**
-  **Stand-Up Paddleboarding (SUP)**

**Primary markets:** Ceará (Cumbuco, Jericoacoara), Piauí (Barra Grande), Maranhão (Atins)


## **Tech Stack**

### **Core Platform**
- **WordPress** 6.0+ (CMS foundation)
- **PHP** 7.4+ (server-side logic)
- **MySQL** 5.7+ (database)
- **JavaScript** ES6+ (frontend interactions)

### **Dependencies**
- **Gravity Forms Pro** (form builder with digital signatures)
- **Gravity PDF** (automated PDF generation)
- **WPML** or Polylang (multilingual support)

### **Integrations**
- **Zapier/Make.com** (automation workflows)
- **WhatsApp Business API** (360Dialog or Twilio)
- **Google Drive API** (automated backups)


## **Installation**

### **Prerequisites**
- WordPress 6.0 or higher
- PHP 7.4 or higher
- MySQL 5.7 or higher
- SSL certificate (HTTPS required for LGPD)

### **Step 1: Install WordPress**
```bash
# Download latest WordPress
wget https://wordpress.org/latest.zip
unzip latest.zip
```

### **Step 2: Install WaverPro Plugin**
```bash
# Clone this repository
git clone https://github.com/emilly-kelda/waverpro.git

# Copy plugin to WordPress
cp -r waverpro/src/plugins/waverpro-core /path/to/wordpress/wp-content/plugins/

# Activate in WordPress Admin
# Plugins → WaverPro Core → Activate
```

### **Step 3: Install Required Plugins**
1. Purchase & install [Gravity Forms Pro](https://www.gravityforms.com/)
2. Install Gravity Forms Signature Add-on
3. Install [Gravity PDF](https://gravitypdf.com/)
4. Install WPML or Polylang for multilingual support

### **Step 4: Configure Integrations**
See [docs/CONFIGURATION.md](docs/CONFIGURATION.md) for detailed setup guide.


## **Quick Start**

### **1. Configure Settings**
Navigate to **WaverPro → Configurações** in WordPress admin:
- Set School ID
- Add Google Drive webhook URL
- Add WhatsApp webhook URL
- Choose primary brand color

### **2. Create Waiver Form**
1. Go to **Forms → New Form** in Gravity Forms
2. Add required fields:
   - Name, Email, Phone
   - Date of Birth, CPF/Passport
   - Activity Type, Class Date
   - Medical Conditions
   - Emergency Contact
   - LGPD Consent (checkbox)
   - Signature (required)

### **3. Set Up PDF Template**
1. Go to **Forms → PDF**
2. Create new PDF template
3. Customize with school branding
4. Map form fields to PDF

### **4. Configure Automations**
See [docs/API_SETUP.md](docs/API_SETUP.md) for:
- Google Drive webhook setup
- WhatsApp API configuration
- Zapier/Make.com workflows


## **Business Model**

### **Pricing Strategy**
- **One-time setup:** R$ 2,200
- **Client provides:** Hosting (R$ 50-200/month), APIs (R$ 250-450/month)
- **30-day support** included
- **Extended support:** Available on request

### **ROI for Schools**
```
Manual Process Costs (Annual):
- Staff time (15h/week × R$ 20/h × 52 weeks): R$ 15,600
- Paper/printing/storage: R$ 2,400
- Legal consultation (annual): R$ 5,000
- Risk of lost documents: R$ 50,000+ (potential lawsuit)
TOTAL RISK: R$ 73,000+

WaverPro Investment:
- Setup: R$ 2,200 (one-time)
- Operating costs: R$ 300/month (R$ 3,600/year)
TOTAL: R$ 5,800 first year

SAVINGS: R$ 67,200+ (1,159% ROI)
```


## **Features Comparison**

| Feature | Paper System | Clicksign | WaverPro |
|---------|-------------|-----------|----------|
| **Watersports-specific** | ❌ | ❌ | ✅ |
| **LGPD Compliant** | ❌ | ✅ | ✅ |
| **Medical Alerts** | ❌ | ❌ | ✅ |
| **WhatsApp Integration** | ❌ | ❌ | ✅ |
| **Bulk Operations** | ❌ | ❌ | ✅ |
| **Google Drive Backup** | ❌ | ❌ | ✅ |
| **Multilingual** | ❌ | ⚠️ | ✅ |
| **Pricing** | Free (high risk) | R$ 40-100/month | R$ 2,200 one-time |


## **Project Structure**
```
waverpro/
├── README.md                      # This file
├── LICENSE                        # MIT License
├── .gitignore                     # Git ignore rules
├── docs/                          # Documentation
│   ├── INSTALLATION.md           # Detailed installation guide
│   ├── API_SETUP.md              # API integration guide
│   └── DEPLOYMENT.md             # Client deployment guide
├── src/
│   └── plugins/
│       └── waverpro-core/        # Main WordPress plugin
│           ├── waverpro-core.php # Plugin entry point
│           ├── includes/         # PHP classes
│           │   ├── class-waiver-handler.php
│           │   ├── class-lgpd-compliance.php
│           │   └── class-gravity-forms-integration.php
│           └── admin/            # Admin interface
│               ├── dashboard.php
│               └── settings.php
└── templates/                     # Form & PDF templates
    └── pdf-templates/            # PDF designs
        └── waiver-template.php
```


## **Deployment**

Ready to deploy WaverPro to a client? Follow our comprehensive deployment guide:

**[Complete Deployment Guide](docs/DEPLOYMENT.md)**

**Quick checklist:**
1.  Install WordPress plugins (1 hour)
2.  Configure WaverPro settings (45 min)
3.  Set up API integrations (1 hour)
4.  Train client staff (1 hour)
5.  Collect payment - R$ 2,200

**Total time:** 4-5 hours per client


## **Contributing**

This is a portfolio project showcasing real-world WordPress plugin development. 

**Issues and suggestions welcome!**

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request


## **License**

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.


## **Author**

**Emilly Kelda**

*Building software solutions for the Brazilian watersports industry*

- GitHub: [@emilly-kelda](https://github.com/emilly-kelda)
- LinkedIn: [www.linkedin.com/in/emillyc](https://linkedin.com/in/yourprofile)


## **Acknowledgments**

- Built for Brazilian watersports schools in Ceará, Piauí, and Maranhão
- Inspired by the need for legal compliance in high-risk sports
- Designed with input from kitesurf and windsurf school owners
- LGPD compliance guidance from Brazilian legal experts


## **Support**

For setup assistance or questions:
- Open an [issue](https://github.com/emilly-kelda/waverpro/issues)
- WhatsApp: +55 (62) 98175-7687


## **What's Next?**

### **Version 2.0 Roadmap**
- [ ] Next.js SaaS version (modern stack)
- [ ] Mobile app (React Native)
- [ ] Advanced analytics dashboard
- [ ] Multi-school management
- [ ] API for third-party integrations

**Interested in the SaaS version?** Check the `nextjs-saas` branch (coming soon!)

---

**⭐ If this project helped you, please star the repository!**

---

## **Project Stats**

- **Lines of Code:** ~2,500+
- **Files:** 15+
- **Documentation Pages:** 4
- **Development Time:** 3 days
- **Business Value:** R$ 2,200 per deployment
- **Target Market Size:** 200+ schools in Brazil
