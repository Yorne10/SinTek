# CETAM Official Color Usage Guide

**Project:** SinTek - Sistema de Gestión de Trámites
**Company:** CETAM
**Last Updated:** 2025-11-19

## Important Rules

**DO NOT GUESS COLORS. DO NOT USE COLORS OUTSIDE THE RULES.**

Each category must be used **ONLY** as indicated in this official guide.

---

## Official CETAM Color Usage Table

### 1. PRIMARY COLOR

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$primary` | Dark Slate Gray | `#1F2937` | Main backgrounds (primary buttons, navigation bars, headers), high-contrast text, titles, dominant areas |

**Allowed Usage:**
- Primary buttons (`btn-primary`)
- Navigation bars and sidebars (`bg-gray-800`, `bg-primary`)
- Main headers
- High-contrast text on light backgrounds
- Card/section dominant areas

**Forbidden Usage:**
- ❌ Do NOT use as text on dark backgrounds
- ❌ Do NOT use for state indicators

**Bootstrap Classes:** `btn-primary`, `bg-primary`, `text-primary`, `border-primary`, `bg-gray-800`

---

### 2. SECONDARY COLOR

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$secondary` | Vibrant Orange-Red | `#FB503B` | Highlighted interactive elements (secondary buttons, active icons, status indicators) |

**Allowed Usage:**
- Secondary/action buttons (`btn-secondary`)
- Active navigation items
- Call-to-action elements
- Important status indicators
- Interactive icons (hover states)

**Forbidden Usage:**
- ❌ Do NOT use for large background areas
- ❌ Do NOT use for long text blocks
- ❌ Avoid saturating backgrounds with this color

**Bootstrap Classes:** `btn-secondary`, `bg-secondary`, `text-secondary`, `border-secondary`

---

### 3. TERTIARY COLOR

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$tertiary` | Indigo Dark Blue | `#31316A` | Secondary backgrounds, complementary highlighted areas, graphic details |

**Allowed Usage:**
- Secondary section backgrounds (`btn-tertiary`)
- Complementary highlighted areas
- Graphic details and accents
- Chart/graph elements

**Forbidden Usage:**
- ❌ Do NOT use in long text blocks
- ❌ Do NOT mix with Primary in the same visual hierarchy level

**Bootstrap Classes:** `btn-tertiary`, `bg-tertiary`, `text-tertiary`, `border-tertiary`

---

### 4. LIGHT NEUTRAL COLORS

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$white` | White | `#FFFFFF` | General backgrounds, cards, clean areas |
| `$gray-50` | Gray 50 | `#F9FAFB` | General backgrounds, cards, clean areas |
| `$gray-100` | Gray 100 | `#F2F4F6` | General backgrounds, cards, clean areas, separators, table stripes |

**Allowed Usage:**
- Page backgrounds
- Card backgrounds
- Modal/dialog backgrounds
- Table row alternating backgrounds
- Clean, neutral areas

**Forbidden Usage:**
- ❌ Do NOT use for main text or icons on light backgrounds (low contrast)
- ❌ Do NOT use for state indicators

**Bootstrap Classes:** `bg-white`, `text-white`, `bg-gray-50`, `bg-gray-100`

---

### 5. MEDIUM NEUTRAL COLORS

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$gray-200` | Gray 200 | `#E5E7EB` | Borders, neutral areas, table stripes |
| `$gray-300` | Gray 300 | `#D1D5DB` | Borders, neutral iconography |
| `$gray-400` | Gray 400 | `#9CA3AF` | Borders, secondary text, low-priority labels |
| `$gray-500` | Gray 500 | `#6B7280` | Borders, neutral iconography, secondary text |
| `$gray-600` | Gray 600 | `#4B5563` | Borders, neutral iconography, secondary text |

**Allowed Usage:**
- Element borders
- Dividers and separators
- Secondary/helper text
- Disabled states
- Low-priority labels
- Neutral icons

**Forbidden Usage:**
- ❌ Do NOT use for state colors (success, error, warning, info)
- ❌ Do NOT use for alerts or notifications

**Bootstrap Classes:** `border-gray-200`, `text-gray-400`, `text-gray-500`, `text-gray-600`, `bg-gray-200`

---

### 6. DARK NEUTRAL COLORS

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$gray-700` | Gray 700 | `#374151` | High-contrast text, reinforces visual hierarchy |
| `$gray-800` | Gray 800 | `#1F2937` | High-contrast text, icons on light backgrounds (same as Primary) |
| `$gray-900` | Gray 900 | `#111827` | High-contrast text, icons on light backgrounds |

**Allowed Usage:**
- Body text on light backgrounds
- Headers and titles
- Icons on light backgrounds
- High-contrast UI elements

**Forbidden Usage:**
- ❌ Do NOT use to communicate states (use semantic colors instead)

**Bootstrap Classes:** `text-gray-700`, `text-gray-800`, `text-gray-900`, `bg-gray-800`, `bg-gray-900`

---

### 7. SUCCESS COLOR

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$success` / `$green` | Green | `#10B981` | Completed states, confirmations, approval buttons, positive messages |

**Allowed Usage:**
- Success messages and alerts (`alert-success`)
- Completed status badges (`badge bg-success`)
- Approval/confirm buttons
- Positive indicators (checkmarks, up arrows)
- Progress bars for completed tasks
- Text indicating positive results (`text-success`)

**Forbidden Usage:**
- ❌ Do NOT use for initial or neutral actions
- ❌ Do NOT use for in-progress states (use Info instead)

**Bootstrap Classes:** `btn-success`, `bg-success`, `text-success`, `border-success`, `alert-success`, `badge bg-success`

**Example Usage:**
```html
<span class="badge bg-success">Completado</span>
<div class="alert alert-success">Trámite aprobado exitosamente</div>
<button class="btn btn-success">Aprobar</button>
<div class="text-success">+12.5%</div>
```

---

### 8. DANGER COLOR

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$danger` / `$red` | Red | `#E11D48` | Errors, cancellations, destructive actions (delete, reject) |

**Allowed Usage:**
- Error messages and alerts (`alert-danger`)
- Failed status badges (`badge bg-danger`)
- Delete/remove buttons
- Reject/cancel actions
- Negative indicators (X marks, down arrows)
- Validation errors
- Text indicating negative results (`text-danger`)

**Forbidden Usage:**
- ❌ Do NOT use for positive or informational content
- ❌ Do NOT use for warning states (use Warning instead)

**Bootstrap Classes:** `btn-danger`, `bg-danger`, `text-danger`, `border-danger`, `alert-danger`, `badge bg-danger`

**Example Usage:**
```html
<span class="badge bg-danger">Rechazado</span>
<div class="alert alert-danger">Error al procesar la solicitud</div>
<button class="btn btn-danger">Eliminar</button>
<div class="text-danger">-9.45%</div>
```

---

### 9. WARNING COLOR

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$warning` / `$yellow` | Amber/Yellow | `#F3C78E` | Pending states, waiting processes, moderate alerts |

**Allowed Usage:**
- Warning messages and alerts (`alert-warning`)
- Pending status badges (`badge bg-warning`)
- Caution indicators
- Waiting/queue states
- Moderate alerts
- Review needed indicators
- Text indicating caution (`text-warning`)

**Forbidden Usage:**
- ❌ Do NOT use for success states
- ❌ Do NOT use for error states

**Bootstrap Classes:** `btn-warning`, `bg-warning`, `text-warning`, `border-warning`, `alert-warning`, `badge bg-warning`

**Example Usage:**
```html
<span class="badge bg-warning">Pendiente</span>
<div class="alert alert-warning">28 trámites requieren validación</div>
<button class="btn btn-warning">Revisar</button>
```

---

### 10. INFO COLOR

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$info` / `$teal` | Light Blue | `#1E90FF` | Active/in-progress states, informational messages, neutral actions |

**Allowed Usage:**
- Informational messages and alerts (`alert-info`)
- In-progress status badges (`badge bg-info`)
- Active process indicators
- Informational tooltips
- Neutral informational actions
- Help/information buttons
- Text indicating active states (`text-info`)

**Forbidden Usage:**
- ❌ Do NOT use for success states (use Success instead)
- ❌ Do NOT use for error states (use Danger instead)

**Bootstrap Classes:** `btn-info`, `bg-info`, `text-info`, `border-info`, `alert-info`, `badge bg-info`

**Example Usage:**
```html
<span class="badge bg-info">En proceso</span>
<div class="alert alert-info">Sistema operando con normalidad</div>
<button class="btn btn-info">Más información</button>
```

---

### 11. COMPLEMENTARY COLORS (Restricted Use)

These colors are **ONLY** for comparative charts, illustrations, and external components. **DO NOT** use for main states or institutional identity.

| Variable | Name | Hex | Usage |
|----------|------|-----|-------|
| `$blue` | Blue | `#2361CE` | Charts, graphs, illustrations only |
| `$indigo` | Indigo | `#4F46E5` | Charts, graphs, illustrations only |
| `$purple` | Purple | `#7C3AED` | Charts, graphs, illustrations only |
| `$pink` | Pink | `#EF4683` | Charts, graphs, illustrations only |
| `$cyan` | Cyan | `#63B1BD` | Charts, graphs, illustrations only |
| `$brown` | Brown | `#B9A084` | Charts, graphs, illustrations only |

**Allowed Usage:**
- Multi-series charts and graphs
- Data visualization with multiple categories
- Illustrations and graphics
- External component styling (when necessary)

**Forbidden Usage:**
- ❌ Do NOT use for buttons, alerts, or badges
- ❌ Do NOT use for state indicators
- ❌ Do NOT use for main institutional identity

---

## Table Color Usage

**IMPORTANT:** In tables, **DO NOT use colored backgrounds**. Use only text colors.

### Correct Table Usage

```html
<table class="table">
    <thead class="thead-light">
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-primary fw-bold">Value</td>
            <td class="text-gray-500">Description</td>
        </tr>
        <tr>
            <td class="text-success">Success</td>
            <td class="text-danger">Error</td>
        </tr>
    </tbody>
</table>
```

### Reference Example

See `bootstrap-tables.blade.php` for correct implementation examples.

---

## Common Bootstrap Class Patterns

### Buttons
- `btn-primary` - Main actions (Dark Slate Gray)
- `btn-secondary` - Secondary actions (Vibrant Orange-Red)
- `btn-tertiary` - Tertiary actions (Indigo Dark Blue)
- `btn-success` - Confirm/approve actions (Green)
- `btn-danger` - Delete/reject actions (Red)
- `btn-warning` - Caution actions (Amber)
- `btn-info` - Information actions (Light Blue)
- `btn-outline-{color}` - Outlined variants

### Badges/Status
- `badge bg-success` - Completed states
- `badge bg-info` - In progress states
- `badge bg-warning` - Pending states
- `badge bg-danger` - Failed/rejected states

### Alerts
- `alert alert-success` - Success messages
- `alert alert-info` - Informational messages
- `alert alert-warning` - Warning messages
- `alert alert-danger` - Error messages

### Progress Bars
- `progress-bar bg-success` - Completed progress
- `progress-bar bg-info` - Active progress
- `progress-bar bg-warning` - Pending progress
- `progress-bar bg-danger` - Failed progress

### Text Colors
- `text-primary` - Primary emphasis
- `text-secondary` - Secondary emphasis
- `text-success` - Positive text
- `text-danger` - Negative text
- `text-warning` - Caution text
- `text-info` - Informational text
- `text-gray-{100-900}` - Neutral text
- `text-white` - White text (on dark backgrounds)

### Background Colors
- `bg-primary` - Primary backgrounds
- `bg-gray-800` - Dark backgrounds (sidebar, header)
- `bg-white` - White backgrounds
- `bg-gray-{50-900}` - Neutral backgrounds

---

## Quick Reference Checklist

### Before Using a Color, Ask:

1. **Is this color allowed for my use case?**
   - Check the "Allowed Usage" section for each color

2. **Am I using it in a forbidden context?**
   - Check the "Forbidden Usage" section for each color

3. **For state indicators:**
   - ✅ Success/Completed → `$success` / Green (`#10B981`)
   - ✅ In Progress/Active → `$info` / Light Blue (`#1E90FF`)
   - ✅ Pending/Warning → `$warning` / Amber (`#F3C78E`)
   - ✅ Error/Failed → `$danger` / Red (`#E11D48`)

4. **For buttons:**
   - ✅ Main action → `btn-primary` (Dark Slate Gray)
   - ✅ Secondary action → `btn-secondary` (Vibrant Orange-Red)
   - ✅ Confirm/Approve → `btn-success` (Green)
   - ✅ Delete/Reject → `btn-danger` (Red)
   - ✅ Information → `btn-info` (Light Blue)

5. **For backgrounds:**
   - ✅ Navigation/Sidebar → `bg-gray-800` or `bg-primary`
   - ✅ Cards/Content → `bg-white`, `bg-gray-50`, `bg-gray-100`
   - ✅ Borders/Dividers → `border-gray-200` through `border-gray-600`

---

## Implementation Status

### Updated Files
- ✅ `resources/scss/volt/_variables.scss` - All color variables updated with official CETAM colors and usage documentation
- ✅ Compiled CSS (`public/css/volt.css`)

### Color Changes Made
1. **$info color corrected:** Changed from `$blue` (#2361CE) to `$teal` (#1E90FF) for proper active/in-progress state representation
2. **Added comprehensive documentation comments** to all color variables
3. **Color values verified** against official CETAM color table (all hex values match exactly)

### Current Compliance
- ✅ All color hex values match official CETAM table
- ✅ Semantic colors ($success, $info, $warning, $danger) correctly mapped
- ✅ Gray scale colors correctly defined and documented
- ✅ Complementary colors identified as restricted use
- ✅ Tables use text colors only (no background colors)
- ✅ Bootstrap class usage follows CETAM guidelines

---

## Developer Notes

### When Adding New Features
1. **Always** refer to this guide before selecting colors
2. **Never** create custom colors outside the official palette
3. **Use** Bootstrap utility classes (bg-*, text-*, border-*) instead of inline styles
4. **Test** color contrast for accessibility (text should be readable)
5. **Document** any new color usage patterns

### SCSS Variable Usage
When writing custom SCSS, use the variables:
```scss
// ✅ CORRECT
.my-component {
    background-color: $primary;
    color: $white;
    border: 1px solid $gray-300;
}

// ❌ INCORRECT - Don't use raw hex values
.my-component {
    background-color: #1F2937;
    color: #ffffff;
}
```

---

## Maintenance

This color system is managed in:
- **Source:** `resources/scss/volt/_variables.scss`
- **Compiled:** `public/css/volt.css`

To recompile after changes:
```bash
npm run production
```

---

**Last Review:** 2025-11-19
**Next Review:** Quarterly or when brand guidelines update
**Maintained by:** Development Team
