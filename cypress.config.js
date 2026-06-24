import { defineConfig } from "cypress";
import cypressMochawesomeReporterPlugin from "cypress-mochawesome-reporter/plugin.js";

export default defineConfig({
  reporter: "cypress-mochawesome-reporter",
  reporterOptions: {
    charts: true,
    reportPageTitle: "Explora Nusantara - E2E Test Report",
    embeddedScreenshots: true,
    inlineAssets: true,
    saveAllAttempts: false,
  },
  e2e: {
    baseUrl: "https://exploranusantara.com",
    specPattern: "cypress/e2e/**/*.cy.{js,jsx,ts,tsx}",
    supportFile: "cypress/support/e2e.js",
    viewportWidth: 1280,
    viewportHeight: 720,
    screenshotOnRunFailure: true,
    video: false,
    trashAssetsBeforeRuns: false,
    defaultCommandTimeout: 15000,
    setupNodeEvents(on, config) {
      cypressMochawesomeReporterPlugin(on);
      return config;
    },
  },
});
