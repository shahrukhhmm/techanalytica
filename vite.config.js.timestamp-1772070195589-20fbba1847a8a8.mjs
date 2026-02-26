// vite.config.js
import { defineConfig } from "file:///D:/Laravel/techanalytica/node_modules/vite/dist/node/index.js";
import laravel from "file:///D:/Laravel/techanalytica/node_modules/laravel-vite-plugin/dist/index.js";
import html from "file:///D:/Laravel/techanalytica/node_modules/@rollup/plugin-html/dist/es/index.js";
import { glob } from "file:///D:/Laravel/techanalytica/node_modules/glob/dist/esm/index.js";
import path2 from "path";

// vite.icons.plugin.js
import fs from "fs/promises";
import path from "path";
import { getIconsCSS } from "file:///D:/Laravel/techanalytica/node_modules/@iconify/utils/lib/index.mjs";
function iconifyPlugin() {
  return {
    name: "vite-iconify-plugin",
    apply: "build",
    // Run only during build
    async buildStart() {
      console.log("\u{1F528} Generating iconify CSS file...");
      try {
        const iconSetPaths = [
          path.resolve(process.cwd(), "node_modules/@iconify/json/json/bx.json"),
          path.resolve(process.cwd(), "node_modules/@iconify/json/json/bxl.json"),
          path.resolve(process.cwd(), "node_modules/@iconify/json/json/bxs.json")
        ];
        const iconSets = await Promise.all(
          iconSetPaths.map(async (filePath) => {
            const data = await fs.readFile(filePath, "utf-8");
            return JSON.parse(data);
          })
        );
        const allIcons = iconSets.map((iconSet) => {
          return getIconsCSS(iconSet, Object.keys(iconSet.icons), {
            iconSelector: ".{prefix}-{name}",
            commonSelector: ".bx",
            format: "expanded"
          });
        }).join("\n");
        const outputPath = path.resolve(process.cwd(), "resources/assets/vendor/fonts/iconify/iconify.css");
        const dir = path.dirname(outputPath);
        await fs.mkdir(dir, { recursive: true });
        await fs.writeFile(outputPath, allIcons, "utf8");
        console.log(`\u2705 Iconify CSS generated at: ${outputPath}`);
      } catch (error) {
        console.error("\u274C Error generating Iconify CSS or copying additional files:", error);
      }
    }
  };
}

// vite.config.js
var __vite_injected_original_dirname = "D:\\Laravel\\techanalytica";
function GetFilesArray(query) {
  return glob.sync(query);
}
var pageJsFiles = GetFilesArray("resources/assets/js/*.js");
var vendorJsFiles = GetFilesArray("resources/assets/vendor/js/*.js");
var LibsJsFiles = GetFilesArray("resources/assets/vendor/libs/**/*.js");
var LibsScssFiles = GetFilesArray("resources/assets/vendor/libs/**/!(_)*.scss");
var LibsCssFiles = GetFilesArray("resources/assets/vendor/libs/**/*.css");
var CoreScssFiles = GetFilesArray("resources/assets/vendor/scss/**/!(_)*.scss");
var FontsScssFiles = GetFilesArray("resources/assets/vendor/fonts/!(_)*.scss");
var FontsJsFiles = GetFilesArray("resources/assets/vendor/fonts/**/!(_)*.js");
var FontsCssFiles = GetFilesArray("resources/assets/vendor/fonts/**/!(_)*.css");
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/assets/css/demo.css",
        "resources/js/app.js",
        ...pageJsFiles,
        ...vendorJsFiles,
        ...LibsJsFiles,
        ...CoreScssFiles,
        ...LibsScssFiles,
        ...LibsCssFiles,
        ...FontsScssFiles,
        ...FontsJsFiles,
        ...FontsCssFiles
      ],
      refresh: true
    }),
    html(),
    iconifyPlugin()
  ],
  resolve: {
    alias: {
      "@": path2.resolve(__vite_injected_original_dirname, "resources")
    }
  },
  json: {
    stringify: true
    // Helps with JSON import compatibility
  },
  build: {
    commonjsOptions: {
      include: [/node_modules/]
      // Helps with importing CommonJS modules
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiLCAidml0ZS5pY29ucy5wbHVnaW4uanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFxMYXJhdmVsXFxcXHRlY2hhbmFseXRpY2FcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkQ6XFxcXExhcmF2ZWxcXFxcdGVjaGFuYWx5dGljYVxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vRDovTGFyYXZlbC90ZWNoYW5hbHl0aWNhL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCBodG1sIGZyb20gJ0Byb2xsdXAvcGx1Z2luLWh0bWwnO1xuaW1wb3J0IHsgZ2xvYiB9IGZyb20gJ2dsb2InO1xuaW1wb3J0IHBhdGggZnJvbSAncGF0aCc7XG5pbXBvcnQgaWNvbnNQbHVnaW4gZnJvbSAnLi92aXRlLmljb25zLnBsdWdpbi5qcyc7XG5cbi8qKlxuICogR2V0IEZpbGVzIGZyb20gYSBkaXJlY3RvcnlcbiAqIEBwYXJhbSB7c3RyaW5nfSBxdWVyeVxuICogQHJldHVybnMgYXJyYXlcbiAqL1xuZnVuY3Rpb24gR2V0RmlsZXNBcnJheShxdWVyeSkge1xuICByZXR1cm4gZ2xvYi5zeW5jKHF1ZXJ5KTtcbn1cblxuLy8gUGFnZSBKUyBGaWxlc1xuY29uc3QgcGFnZUpzRmlsZXMgPSBHZXRGaWxlc0FycmF5KCdyZXNvdXJjZXMvYXNzZXRzL2pzLyouanMnKTtcblxuLy8gUHJvY2Vzc2luZyBWZW5kb3IgSlMgRmlsZXNcbmNvbnN0IHZlbmRvckpzRmlsZXMgPSBHZXRGaWxlc0FycmF5KCdyZXNvdXJjZXMvYXNzZXRzL3ZlbmRvci9qcy8qLmpzJyk7XG5cbi8vIFByb2Nlc3NpbmcgTGlicyBKUyBGaWxlc1xuY29uc3QgTGlic0pzRmlsZXMgPSBHZXRGaWxlc0FycmF5KCdyZXNvdXJjZXMvYXNzZXRzL3ZlbmRvci9saWJzLyoqLyouanMnKTtcblxuLy8gUHJvY2Vzc2luZyBMaWJzIFNjc3MgJiBDc3MgRmlsZXNcbmNvbnN0IExpYnNTY3NzRmlsZXMgPSBHZXRGaWxlc0FycmF5KCdyZXNvdXJjZXMvYXNzZXRzL3ZlbmRvci9saWJzLyoqLyEoXykqLnNjc3MnKTtcbmNvbnN0IExpYnNDc3NGaWxlcyA9IEdldEZpbGVzQXJyYXkoJ3Jlc291cmNlcy9hc3NldHMvdmVuZG9yL2xpYnMvKiovKi5jc3MnKTtcblxuLy8gUHJvY2Vzc2luZyBDb3JlLCBUaGVtZXMgJiBQYWdlcyBTY3NzIEZpbGVzXG5jb25zdCBDb3JlU2Nzc0ZpbGVzID0gR2V0RmlsZXNBcnJheSgncmVzb3VyY2VzL2Fzc2V0cy92ZW5kb3Ivc2Nzcy8qKi8hKF8pKi5zY3NzJyk7XG5cbi8vIFByb2Nlc3NpbmcgRm9udHMgU2NzcyAmIEpTIEZpbGVzXG5jb25zdCBGb250c1Njc3NGaWxlcyA9IEdldEZpbGVzQXJyYXkoJ3Jlc291cmNlcy9hc3NldHMvdmVuZG9yL2ZvbnRzLyEoXykqLnNjc3MnKTtcbmNvbnN0IEZvbnRzSnNGaWxlcyA9IEdldEZpbGVzQXJyYXkoJ3Jlc291cmNlcy9hc3NldHMvdmVuZG9yL2ZvbnRzLyoqLyEoXykqLmpzJyk7XG5jb25zdCBGb250c0Nzc0ZpbGVzID0gR2V0RmlsZXNBcnJheSgncmVzb3VyY2VzL2Fzc2V0cy92ZW5kb3IvZm9udHMvKiovIShfKSouY3NzJyk7XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gIHBsdWdpbnM6IFtcbiAgICBsYXJhdmVsKHtcbiAgICAgIGlucHV0OiBbXG4gICAgICAgICdyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLFxuICAgICAgICAncmVzb3VyY2VzL2Fzc2V0cy9jc3MvZGVtby5jc3MnLFxuICAgICAgICAncmVzb3VyY2VzL2pzL2FwcC5qcycsXG4gICAgICAgIC4uLnBhZ2VKc0ZpbGVzLFxuICAgICAgICAuLi52ZW5kb3JKc0ZpbGVzLFxuICAgICAgICAuLi5MaWJzSnNGaWxlcyxcbiAgICAgICAgLi4uQ29yZVNjc3NGaWxlcyxcbiAgICAgICAgLi4uTGlic1Njc3NGaWxlcyxcbiAgICAgICAgLi4uTGlic0Nzc0ZpbGVzLFxuICAgICAgICAuLi5Gb250c1Njc3NGaWxlcyxcbiAgICAgICAgLi4uRm9udHNKc0ZpbGVzLFxuICAgICAgICAuLi5Gb250c0Nzc0ZpbGVzXG4gICAgICBdLFxuICAgICAgcmVmcmVzaDogdHJ1ZVxuICAgIH0pLFxuICAgIGh0bWwoKSxcbiAgICBpY29uc1BsdWdpbigpXG4gIF0sXG4gIHJlc29sdmU6IHtcbiAgICBhbGlhczoge1xuICAgICAgJ0AnOiBwYXRoLnJlc29sdmUoX19kaXJuYW1lLCAncmVzb3VyY2VzJylcbiAgICB9XG4gIH0sXG4gIGpzb246IHtcbiAgICBzdHJpbmdpZnk6IHRydWUgLy8gSGVscHMgd2l0aCBKU09OIGltcG9ydCBjb21wYXRpYmlsaXR5XG4gIH0sXG4gIGJ1aWxkOiB7XG4gICAgY29tbW9uanNPcHRpb25zOiB7XG4gICAgICBpbmNsdWRlOiBbL25vZGVfbW9kdWxlcy9dIC8vIEhlbHBzIHdpdGggaW1wb3J0aW5nIENvbW1vbkpTIG1vZHVsZXNcbiAgICB9XG4gIH1cbn0pO1xuIiwgImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFxMYXJhdmVsXFxcXHRlY2hhbmFseXRpY2FcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkQ6XFxcXExhcmF2ZWxcXFxcdGVjaGFuYWx5dGljYVxcXFx2aXRlLmljb25zLnBsdWdpbi5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vRDovTGFyYXZlbC90ZWNoYW5hbHl0aWNhL3ZpdGUuaWNvbnMucGx1Z2luLmpzXCI7aW1wb3J0IGZzIGZyb20gJ2ZzL3Byb21pc2VzJztcbmltcG9ydCBwYXRoIGZyb20gJ3BhdGgnO1xuaW1wb3J0IHsgZ2V0SWNvbnNDU1MgfSBmcm9tICdAaWNvbmlmeS91dGlscyc7XG5cbmV4cG9ydCBkZWZhdWx0IGZ1bmN0aW9uIGljb25pZnlQbHVnaW4oKSB7XG4gIHJldHVybiB7XG4gICAgbmFtZTogJ3ZpdGUtaWNvbmlmeS1wbHVnaW4nLFxuICAgIGFwcGx5OiAnYnVpbGQnLCAvLyBSdW4gb25seSBkdXJpbmcgYnVpbGRcblxuICAgIGFzeW5jIGJ1aWxkU3RhcnQoKSB7XG4gICAgICBjb25zb2xlLmxvZygnXHVEODNEXHVERDI4IEdlbmVyYXRpbmcgaWNvbmlmeSBDU1MgZmlsZS4uLicpO1xuXG4gICAgICB0cnkge1xuICAgICAgICBjb25zdCBpY29uU2V0UGF0aHMgPSBbXG4gICAgICAgICAgcGF0aC5yZXNvbHZlKHByb2Nlc3MuY3dkKCksICdub2RlX21vZHVsZXMvQGljb25pZnkvanNvbi9qc29uL2J4Lmpzb24nKSxcbiAgICAgICAgICBwYXRoLnJlc29sdmUocHJvY2Vzcy5jd2QoKSwgJ25vZGVfbW9kdWxlcy9AaWNvbmlmeS9qc29uL2pzb24vYnhsLmpzb24nKSxcbiAgICAgICAgICBwYXRoLnJlc29sdmUocHJvY2Vzcy5jd2QoKSwgJ25vZGVfbW9kdWxlcy9AaWNvbmlmeS9qc29uL2pzb24vYnhzLmpzb24nKVxuICAgICAgICBdO1xuXG4gICAgICAgIGNvbnN0IGljb25TZXRzID0gYXdhaXQgUHJvbWlzZS5hbGwoXG4gICAgICAgICAgaWNvblNldFBhdGhzLm1hcChhc3luYyBmaWxlUGF0aCA9PiB7XG4gICAgICAgICAgICBjb25zdCBkYXRhID0gYXdhaXQgZnMucmVhZEZpbGUoZmlsZVBhdGgsICd1dGYtOCcpO1xuICAgICAgICAgICAgcmV0dXJuIEpTT04ucGFyc2UoZGF0YSk7XG4gICAgICAgICAgfSlcbiAgICAgICAgKTtcblxuICAgICAgICBjb25zdCBhbGxJY29ucyA9IGljb25TZXRzXG4gICAgICAgICAgLm1hcChpY29uU2V0ID0+IHtcbiAgICAgICAgICAgIHJldHVybiBnZXRJY29uc0NTUyhpY29uU2V0LCBPYmplY3Qua2V5cyhpY29uU2V0Lmljb25zKSwge1xuICAgICAgICAgICAgICBpY29uU2VsZWN0b3I6ICcue3ByZWZpeH0te25hbWV9JyxcbiAgICAgICAgICAgICAgY29tbW9uU2VsZWN0b3I6ICcuYngnLFxuICAgICAgICAgICAgICBmb3JtYXQ6ICdleHBhbmRlZCdcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgIH0pXG4gICAgICAgICAgLmpvaW4oJ1xcbicpO1xuXG4gICAgICAgIGNvbnN0IG91dHB1dFBhdGggPSBwYXRoLnJlc29sdmUocHJvY2Vzcy5jd2QoKSwgJ3Jlc291cmNlcy9hc3NldHMvdmVuZG9yL2ZvbnRzL2ljb25pZnkvaWNvbmlmeS5jc3MnKTtcbiAgICAgICAgY29uc3QgZGlyID0gcGF0aC5kaXJuYW1lKG91dHB1dFBhdGgpO1xuICAgICAgICBhd2FpdCBmcy5ta2RpcihkaXIsIHsgcmVjdXJzaXZlOiB0cnVlIH0pO1xuICAgICAgICBhd2FpdCBmcy53cml0ZUZpbGUob3V0cHV0UGF0aCwgYWxsSWNvbnMsICd1dGY4Jyk7XG5cbiAgICAgICAgY29uc29sZS5sb2coYFx1MjcwNSBJY29uaWZ5IENTUyBnZW5lcmF0ZWQgYXQ6ICR7b3V0cHV0UGF0aH1gKTtcbiAgICAgIH0gY2F0Y2ggKGVycm9yKSB7XG4gICAgICAgIGNvbnNvbGUuZXJyb3IoJ1x1Mjc0QyBFcnJvciBnZW5lcmF0aW5nIEljb25pZnkgQ1NTIG9yIGNvcHlpbmcgYWRkaXRpb25hbCBmaWxlczonLCBlcnJvcik7XG4gICAgICB9XG4gICAgfVxuICB9O1xufVxuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUFnUSxTQUFTLG9CQUFvQjtBQUM3UixPQUFPLGFBQWE7QUFDcEIsT0FBTyxVQUFVO0FB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
