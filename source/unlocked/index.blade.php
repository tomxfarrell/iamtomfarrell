<!doctype html>
<html class="staticrypt-html">
<head>
    <meta charset="utf-8">
    <title>Protected Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- do not cache this page -->
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache"/>

    <style>
        .staticrypt-hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #eee;
        }

        .staticrypt-page {
            width: 360px;
            padding: 8% 0 0;
            margin: auto;
            box-sizing: border-box;
        }

        .staticrypt-form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }

        .staticrypt-form input[type="password"] {
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .staticrypt-form .staticrypt-decrypt-button {
            text-transform: uppercase;
            outline: 0;
            background: #4CAF50;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            cursor: pointer;
        }

        .staticrypt-form .staticrypt-decrypt-button:hover, .staticrypt-form .staticrypt-decrypt-button:active, .staticrypt-form .staticrypt-decrypt-button:focus {
            background: #43A047;
        }

        .staticrypt-html {
            height: 100%;
        }

        .staticrypt-body {
            margin-bottom: 1em;
            background: #302E6F; /* fallback for old browsers */
            font-family: "Arial", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .staticrypt-instructions {
            margin-top: -1em;
            margin-bottom: 1em;
        }

        .staticrypt-title {
            font-size: 1.5em;
        }

        .staticrypt-footer {
            position: fixed;
            height: 20px;
            font-size: 16px;
            padding: 2px;
            bottom: 0;
            left: 0;
            right: 0;
            margin-bottom: 0;
        }

        .staticrypt-footer p {
            margin: 2px;
            text-align: center;
            float: right;
        }

        .staticrypt-footer a {
            text-decoration: none;
        }

        label.staticrypt-remember {
            display: flex;
            align-items: center;
            margin-bottom: 1em;
        }

        .staticrypt-remember input[type=checkbox] {
            transform: scale(1.5);
            margin-right: 1em;
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body class="staticrypt-body">
<div class="staticrypt-page">
    <div class="staticrypt-form">
        <div class="staticrypt-instructions">
            <p class="staticrypt-title">Protected Page</p>
            <p></p>
        </div>

        <hr class="staticrypt-hr">

        <form id="staticrypt-form" action="#" method="post">
            <input id="staticrypt-password"
                   type="password"
                   name="password"
                   placeholder="Passphrase"
                   autofocus/>

            <label id="staticrypt-remember-label" class="staticrypt-remember hidden">
                <input id="staticrypt-remember"
                       type="checkbox"
                       name="remember"/>
                Remember me
            </label>

            <input type="submit" class="staticrypt-decrypt-button" value="Unlock"/>
        </form>
    </div>

</div>
<footer class="staticrypt-footer">
    <p class="pull-right">Created with <a href="https://robinmoisson.github.io/staticrypt">StatiCrypt</a></p>
</footer>


<script>/**
 * Crypto JS 3.1.9-1
 * Copied as is from https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js
 */

;(function (root, factory) {
    if (typeof exports === "object") {
        // CommonJS
        module.exports = exports = factory();
    }
    else if (typeof define === "function" && define.amd) {
        // AMD
        define([], factory);
    }
    else {
        // Global (browser)
        root.CryptoJS = factory();
    }
}(this, function () {

    /**
     * CryptoJS core components.
     */
    var CryptoJS = CryptoJS || (function (Math, undefined) {
        /*
	     * Local polyfil of Object.create
	     */
        var create = Object.create || (function () {
            function F() {};

            return function (obj) {
                var subtype;

                F.prototype = obj;

                subtype = new F();

                F.prototype = null;

                return subtype;
            };
        }())

        /**
         * CryptoJS namespace.
         */
        var C = {};

        /**
         * Library namespace.
         */
        var C_lib = C.lib = {};

        /**
         * Base object for prototypal inheritance.
         */
        var Base = C_lib.Base = (function () {


            return {
                /**
                 * Creates a new object that inherits from this object.
                 *
                 * @param {Object} overrides Properties to copy into the new object.
                 *
                 * @return {Object} The new object.
                 *
                 * @static
                 *
                 * @example
                 *
                 *     var MyType = CryptoJS.lib.Base.extend({
	             *         field: 'value',
	             *
	             *         method: function () {
	             *         }
	             *     });
                 */
                extend: function (overrides) {
                    // Spawn
                    var subtype = create(this);

                    // Augment
                    if (overrides) {
                        subtype.mixIn(overrides);
                    }

                    // Create default initializer
                    if (!subtype.hasOwnProperty('init') || this.init === subtype.init) {
                        subtype.init = function () {
                            subtype.$super.init.apply(this, arguments);
                        };
                    }

                    // Initializer's prototype is the subtype object
                    subtype.init.prototype = subtype;

                    // Reference supertype
                    subtype.$super = this;

                    return subtype;
                },

                /**
                 * Extends this object and runs the init method.
                 * Arguments to create() will be passed to init().
                 *
                 * @return {Object} The new object.
                 *
                 * @static
                 *
                 * @example
                 *
                 *     var instance = MyType.create();
                 */
                create: function () {
                    var instance = this.extend();
                    instance.init.apply(instance, arguments);

                    return instance;
                },

                /**
                 * Initializes a newly created object.
                 * Override this method to add some logic when your objects are created.
                 *
                 * @example
                 *
                 *     var MyType = CryptoJS.lib.Base.extend({
	             *         init: function () {
	             *             // ...
	             *         }
	             *     });
                 */
                init: function () {
                },

                /**
                 * Copies properties into this object.
                 *
                 * @param {Object} properties The properties to mix in.
                 *
                 * @example
                 *
                 *     MyType.mixIn({
	             *         field: 'value'
	             *     });
                 */
                mixIn: function (properties) {
                    for (var propertyName in properties) {
                        if (properties.hasOwnProperty(propertyName)) {
                            this[propertyName] = properties[propertyName];
                        }
                    }

                    // IE won't copy toString using the loop above
                    if (properties.hasOwnProperty('toString')) {
                        this.toString = properties.toString;
                    }
                },

                /**
                 * Creates a copy of this object.
                 *
                 * @return {Object} The clone.
                 *
                 * @example
                 *
                 *     var clone = instance.clone();
                 */
                clone: function () {
                    return this.init.prototype.extend(this);
                }
            };
        }());

        /**
         * An array of 32-bit words.
         *
         * @property {Array} words The array of 32-bit words.
         * @property {number} sigBytes The number of significant bytes in this word array.
         */
        var WordArray = C_lib.WordArray = Base.extend({
            /**
             * Initializes a newly created word array.
             *
             * @param {Array} words (Optional) An array of 32-bit words.
             * @param {number} sigBytes (Optional) The number of significant bytes in the words.
             *
             * @example
             *
             *     var wordArray = CryptoJS.lib.WordArray.create();
             *     var wordArray = CryptoJS.lib.WordArray.create([0x00010203, 0x04050607]);
             *     var wordArray = CryptoJS.lib.WordArray.create([0x00010203, 0x04050607], 6);
             */
            init: function (words, sigBytes) {
                words = this.words = words || [];

                if (sigBytes != undefined) {
                    this.sigBytes = sigBytes;
                } else {
                    this.sigBytes = words.length * 4;
                }
            },

            /**
             * Converts this word array to a string.
             *
             * @param {Encoder} encoder (Optional) The encoding strategy to use. Default: CryptoJS.enc.Hex
             *
             * @return {string} The stringified word array.
             *
             * @example
             *
             *     var string = wordArray + '';
             *     var string = wordArray.toString();
             *     var string = wordArray.toString(CryptoJS.enc.Utf8);
             */
            toString: function (encoder) {
                return (encoder || Hex).stringify(this);
            },

            /**
             * Concatenates a word array to this word array.
             *
             * @param {WordArray} wordArray The word array to append.
             *
             * @return {WordArray} This word array.
             *
             * @example
             *
             *     wordArray1.concat(wordArray2);
             */
            concat: function (wordArray) {
                // Shortcuts
                var thisWords = this.words;
                var thatWords = wordArray.words;
                var thisSigBytes = this.sigBytes;
                var thatSigBytes = wordArray.sigBytes;

                // Clamp excess bits
                this.clamp();

                // Concat
                if (thisSigBytes % 4) {
                    // Copy one byte at a time
                    for (var i = 0; i < thatSigBytes; i++) {
                        var thatByte = (thatWords[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                        thisWords[(thisSigBytes + i) >>> 2] |= thatByte << (24 - ((thisSigBytes + i) % 4) * 8);
                    }
                } else {
                    // Copy one word at a time
                    for (var i = 0; i < thatSigBytes; i += 4) {
                        thisWords[(thisSigBytes + i) >>> 2] = thatWords[i >>> 2];
                    }
                }
                this.sigBytes += thatSigBytes;

                // Chainable
                return this;
            },

            /**
             * Removes insignificant bits.
             *
             * @example
             *
             *     wordArray.clamp();
             */
            clamp: function () {
                // Shortcuts
                var words = this.words;
                var sigBytes = this.sigBytes;

                // Clamp
                words[sigBytes >>> 2] &= 0xffffffff << (32 - (sigBytes % 4) * 8);
                words.length = Math.ceil(sigBytes / 4);
            },

            /**
             * Creates a copy of this word array.
             *
             * @return {WordArray} The clone.
             *
             * @example
             *
             *     var clone = wordArray.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);
                clone.words = this.words.slice(0);

                return clone;
            },

            /**
             * Creates a word array filled with random bytes.
             *
             * @param {number} nBytes The number of random bytes to generate.
             *
             * @return {WordArray} The random word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.lib.WordArray.random(16);
             */
            random: function (nBytes) {
                var words = [];

                var r = (function (m_w) {
                    var m_w = m_w;
                    var m_z = 0x3ade68b1;
                    var mask = 0xffffffff;

                    return function () {
                        m_z = (0x9069 * (m_z & 0xFFFF) + (m_z >> 0x10)) & mask;
                        m_w = (0x4650 * (m_w & 0xFFFF) + (m_w >> 0x10)) & mask;
                        var result = ((m_z << 0x10) + m_w) & mask;
                        result /= 0x100000000;
                        result += 0.5;
                        return result * (Math.random() > .5 ? 1 : -1);
                    }
                });

                for (var i = 0, rcache; i < nBytes; i += 4) {
                    var _r = r((rcache || Math.random()) * 0x100000000);

                    rcache = _r() * 0x3ade67b7;
                    words.push((_r() * 0x100000000) | 0);
                }

                return new WordArray.init(words, nBytes);
            }
        });

        /**
         * Encoder namespace.
         */
        var C_enc = C.enc = {};

        /**
         * Hex encoding strategy.
         */
        var Hex = C_enc.Hex = {
            /**
             * Converts a word array to a hex string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The hex string.
             *
             * @static
             *
             * @example
             *
             *     var hexString = CryptoJS.enc.Hex.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var hexChars = [];
                for (var i = 0; i < sigBytes; i++) {
                    var bite = (words[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                    hexChars.push((bite >>> 4).toString(16));
                    hexChars.push((bite & 0x0f).toString(16));
                }

                return hexChars.join('');
            },

            /**
             * Converts a hex string to a word array.
             *
             * @param {string} hexStr The hex string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Hex.parse(hexString);
             */
            parse: function (hexStr) {
                // Shortcut
                var hexStrLength = hexStr.length;

                // Convert
                var words = [];
                for (var i = 0; i < hexStrLength; i += 2) {
                    words[i >>> 3] |= parseInt(hexStr.substr(i, 2), 16) << (24 - (i % 8) * 4);
                }

                return new WordArray.init(words, hexStrLength / 2);
            }
        };

        /**
         * Latin1 encoding strategy.
         */
        var Latin1 = C_enc.Latin1 = {
            /**
             * Converts a word array to a Latin1 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The Latin1 string.
             *
             * @static
             *
             * @example
             *
             *     var latin1String = CryptoJS.enc.Latin1.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var latin1Chars = [];
                for (var i = 0; i < sigBytes; i++) {
                    var bite = (words[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                    latin1Chars.push(String.fromCharCode(bite));
                }

                return latin1Chars.join('');
            },

            /**
             * Converts a Latin1 string to a word array.
             *
             * @param {string} latin1Str The Latin1 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Latin1.parse(latin1String);
             */
            parse: function (latin1Str) {
                // Shortcut
                var latin1StrLength = latin1Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < latin1StrLength; i++) {
                    words[i >>> 2] |= (latin1Str.charCodeAt(i) & 0xff) << (24 - (i % 4) * 8);
                }

                return new WordArray.init(words, latin1StrLength);
            }
        };

        /**
         * UTF-8 encoding strategy.
         */
        var Utf8 = C_enc.Utf8 = {
            /**
             * Converts a word array to a UTF-8 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-8 string.
             *
             * @static
             *
             * @example
             *
             *     var utf8String = CryptoJS.enc.Utf8.stringify(wordArray);
             */
            stringify: function (wordArray) {
                try {
                    return decodeURIComponent(escape(Latin1.stringify(wordArray)));
                } catch (e) {
                    throw new Error('Malformed UTF-8 data');
                }
            },

            /**
             * Converts a UTF-8 string to a word array.
             *
             * @param {string} utf8Str The UTF-8 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf8.parse(utf8String);
             */
            parse: function (utf8Str) {
                return Latin1.parse(unescape(encodeURIComponent(utf8Str)));
            }
        };

        /**
         * Abstract buffered block algorithm template.
         *
         * The property blockSize must be implemented in a concrete subtype.
         *
         * @property {number} _minBufferSize The number of blocks that should be kept unprocessed in the buffer. Default: 0
         */
        var BufferedBlockAlgorithm = C_lib.BufferedBlockAlgorithm = Base.extend({
            /**
             * Resets this block algorithm's data buffer to its initial state.
             *
             * @example
             *
             *     bufferedBlockAlgorithm.reset();
             */
            reset: function () {
                // Initial values
                this._data = new WordArray.init();
                this._nDataBytes = 0;
            },

            /**
             * Adds new data to this block algorithm's buffer.
             *
             * @param {WordArray|string} data The data to append. Strings are converted to a WordArray using UTF-8.
             *
             * @example
             *
             *     bufferedBlockAlgorithm._append('data');
             *     bufferedBlockAlgorithm._append(wordArray);
             */
            _append: function (data) {
                // Convert string to WordArray, else assume WordArray already
                if (typeof data == 'string') {
                    data = Utf8.parse(data);
                }

                // Append
                this._data.concat(data);
                this._nDataBytes += data.sigBytes;
            },

            /**
             * Processes available data blocks.
             *
             * This method invokes _doProcessBlock(offset), which must be implemented by a concrete subtype.
             *
             * @param {boolean} doFlush Whether all blocks and partial blocks should be processed.
             *
             * @return {WordArray} The processed data.
             *
             * @example
             *
             *     var processedData = bufferedBlockAlgorithm._process();
             *     var processedData = bufferedBlockAlgorithm._process(!!'flush');
             */
            _process: function (doFlush) {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;
                var dataSigBytes = data.sigBytes;
                var blockSize = this.blockSize;
                var blockSizeBytes = blockSize * 4;

                // Count blocks ready
                var nBlocksReady = dataSigBytes / blockSizeBytes;
                if (doFlush) {
                    // Round up to include partial blocks
                    nBlocksReady = Math.ceil(nBlocksReady);
                } else {
                    // Round down to include only full blocks,
                    // less the number of blocks that must remain in the buffer
                    nBlocksReady = Math.max((nBlocksReady | 0) - this._minBufferSize, 0);
                }

                // Count words ready
                var nWordsReady = nBlocksReady * blockSize;

                // Count bytes ready
                var nBytesReady = Math.min(nWordsReady * 4, dataSigBytes);

                // Process blocks
                if (nWordsReady) {
                    for (var offset = 0; offset < nWordsReady; offset += blockSize) {
                        // Perform concrete-algorithm logic
                        this._doProcessBlock(dataWords, offset);
                    }

                    // Remove processed words
                    var processedWords = dataWords.splice(0, nWordsReady);
                    data.sigBytes -= nBytesReady;
                }

                // Return processed words
                return new WordArray.init(processedWords, nBytesReady);
            },

            /**
             * Creates a copy of this object.
             *
             * @return {Object} The clone.
             *
             * @example
             *
             *     var clone = bufferedBlockAlgorithm.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);
                clone._data = this._data.clone();

                return clone;
            },

            _minBufferSize: 0
        });

        /**
         * Abstract hasher template.
         *
         * @property {number} blockSize The number of 32-bit words this hasher operates on. Default: 16 (512 bits)
         */
        var Hasher = C_lib.Hasher = BufferedBlockAlgorithm.extend({
            /**
             * Configuration options.
             */
            cfg: Base.extend(),

            /**
             * Initializes a newly created hasher.
             *
             * @param {Object} cfg (Optional) The configuration options to use for this hash computation.
             *
             * @example
             *
             *     var hasher = CryptoJS.algo.SHA256.create();
             */
            init: function (cfg) {
                // Apply config defaults
                this.cfg = this.cfg.extend(cfg);

                // Set initial values
                this.reset();
            },

            /**
             * Resets this hasher to its initial state.
             *
             * @example
             *
             *     hasher.reset();
             */
            reset: function () {
                // Reset data buffer
                BufferedBlockAlgorithm.reset.call(this);

                // Perform concrete-hasher logic
                this._doReset();
            },

            /**
             * Updates this hasher with a message.
             *
             * @param {WordArray|string} messageUpdate The message to append.
             *
             * @return {Hasher} This hasher.
             *
             * @example
             *
             *     hasher.update('message');
             *     hasher.update(wordArray);
             */
            update: function (messageUpdate) {
                // Append
                this._append(messageUpdate);

                // Update the hash
                this._process();

                // Chainable
                return this;
            },

            /**
             * Finalizes the hash computation.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} messageUpdate (Optional) A final message update.
             *
             * @return {WordArray} The hash.
             *
             * @example
             *
             *     var hash = hasher.finalize();
             *     var hash = hasher.finalize('message');
             *     var hash = hasher.finalize(wordArray);
             */
            finalize: function (messageUpdate) {
                // Final message update
                if (messageUpdate) {
                    this._append(messageUpdate);
                }

                // Perform concrete-hasher logic
                var hash = this._doFinalize();

                return hash;
            },

            blockSize: 512/32,

            /**
             * Creates a shortcut function to a hasher's object interface.
             *
             * @param {Hasher} hasher The hasher to create a helper for.
             *
             * @return {Function} The shortcut function.
             *
             * @static
             *
             * @example
             *
             *     var SHA256 = CryptoJS.lib.Hasher._createHelper(CryptoJS.algo.SHA256);
             */
            _createHelper: function (hasher) {
                return function (message, cfg) {
                    return new hasher.init(cfg).finalize(message);
                };
            },

            /**
             * Creates a shortcut function to the HMAC's object interface.
             *
             * @param {Hasher} hasher The hasher to use in this HMAC helper.
             *
             * @return {Function} The shortcut function.
             *
             * @static
             *
             * @example
             *
             *     var HmacSHA256 = CryptoJS.lib.Hasher._createHmacHelper(CryptoJS.algo.SHA256);
             */
            _createHmacHelper: function (hasher) {
                return function (message, key) {
                    return new C_algo.HMAC.init(hasher, key).finalize(message);
                };
            }
        });

        /**
         * Algorithm namespace.
         */
        var C_algo = C.algo = {};

        return C;
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_enc = C.enc;

        /**
         * Base64 encoding strategy.
         */
        var Base64 = C_enc.Base64 = {
            /**
             * Converts a word array to a Base64 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The Base64 string.
             *
             * @static
             *
             * @example
             *
             *     var base64String = CryptoJS.enc.Base64.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;
                var map = this._map;

                // Clamp excess bits
                wordArray.clamp();

                // Convert
                var base64Chars = [];
                for (var i = 0; i < sigBytes; i += 3) {
                    var byte1 = (words[i >>> 2]       >>> (24 - (i % 4) * 8))       & 0xff;
                    var byte2 = (words[(i + 1) >>> 2] >>> (24 - ((i + 1) % 4) * 8)) & 0xff;
                    var byte3 = (words[(i + 2) >>> 2] >>> (24 - ((i + 2) % 4) * 8)) & 0xff;

                    var triplet = (byte1 << 16) | (byte2 << 8) | byte3;

                    for (var j = 0; (j < 4) && (i + j * 0.75 < sigBytes); j++) {
                        base64Chars.push(map.charAt((triplet >>> (6 * (3 - j))) & 0x3f));
                    }
                }

                // Add padding
                var paddingChar = map.charAt(64);
                if (paddingChar) {
                    while (base64Chars.length % 4) {
                        base64Chars.push(paddingChar);
                    }
                }

                return base64Chars.join('');
            },

            /**
             * Converts a Base64 string to a word array.
             *
             * @param {string} base64Str The Base64 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Base64.parse(base64String);
             */
            parse: function (base64Str) {
                // Shortcuts
                var base64StrLength = base64Str.length;
                var map = this._map;
                var reverseMap = this._reverseMap;

                if (!reverseMap) {
                    reverseMap = this._reverseMap = [];
                    for (var j = 0; j < map.length; j++) {
                        reverseMap[map.charCodeAt(j)] = j;
                    }
                }

                // Ignore padding
                var paddingChar = map.charAt(64);
                if (paddingChar) {
                    var paddingIndex = base64Str.indexOf(paddingChar);
                    if (paddingIndex !== -1) {
                        base64StrLength = paddingIndex;
                    }
                }

                // Convert
                return parseLoop(base64Str, base64StrLength, reverseMap);

            },

            _map: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
        };

        function parseLoop(base64Str, base64StrLength, reverseMap) {
            var words = [];
            var nBytes = 0;
            for (var i = 0; i < base64StrLength; i++) {
                if (i % 4) {
                    var bits1 = reverseMap[base64Str.charCodeAt(i - 1)] << ((i % 4) * 2);
                    var bits2 = reverseMap[base64Str.charCodeAt(i)] >>> (6 - (i % 4) * 2);
                    words[nBytes >>> 2] |= (bits1 | bits2) << (24 - (nBytes % 4) * 8);
                    nBytes++;
                }
            }
            return WordArray.create(words, nBytes);
        }
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Constants table
        var T = [];

        // Compute constants
        (function () {
            for (var i = 0; i < 64; i++) {
                T[i] = (Math.abs(Math.sin(i + 1)) * 0x100000000) | 0;
            }
        }());

        /**
         * MD5 hash algorithm.
         */
        var MD5 = C_algo.MD5 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0x67452301, 0xefcdab89,
                    0x98badcfe, 0x10325476
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Swap endian
                for (var i = 0; i < 16; i++) {
                    // Shortcuts
                    var offset_i = offset + i;
                    var M_offset_i = M[offset_i];

                    M[offset_i] = (
                        (((M_offset_i << 8)  | (M_offset_i >>> 24)) & 0x00ff00ff) |
                        (((M_offset_i << 24) | (M_offset_i >>> 8))  & 0xff00ff00)
                    );
                }

                // Shortcuts
                var H = this._hash.words;

                var M_offset_0  = M[offset + 0];
                var M_offset_1  = M[offset + 1];
                var M_offset_2  = M[offset + 2];
                var M_offset_3  = M[offset + 3];
                var M_offset_4  = M[offset + 4];
                var M_offset_5  = M[offset + 5];
                var M_offset_6  = M[offset + 6];
                var M_offset_7  = M[offset + 7];
                var M_offset_8  = M[offset + 8];
                var M_offset_9  = M[offset + 9];
                var M_offset_10 = M[offset + 10];
                var M_offset_11 = M[offset + 11];
                var M_offset_12 = M[offset + 12];
                var M_offset_13 = M[offset + 13];
                var M_offset_14 = M[offset + 14];
                var M_offset_15 = M[offset + 15];

                // Working varialbes
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];

                // Computation
                a = FF(a, b, c, d, M_offset_0,  7,  T[0]);
                d = FF(d, a, b, c, M_offset_1,  12, T[1]);
                c = FF(c, d, a, b, M_offset_2,  17, T[2]);
                b = FF(b, c, d, a, M_offset_3,  22, T[3]);
                a = FF(a, b, c, d, M_offset_4,  7,  T[4]);
                d = FF(d, a, b, c, M_offset_5,  12, T[5]);
                c = FF(c, d, a, b, M_offset_6,  17, T[6]);
                b = FF(b, c, d, a, M_offset_7,  22, T[7]);
                a = FF(a, b, c, d, M_offset_8,  7,  T[8]);
                d = FF(d, a, b, c, M_offset_9,  12, T[9]);
                c = FF(c, d, a, b, M_offset_10, 17, T[10]);
                b = FF(b, c, d, a, M_offset_11, 22, T[11]);
                a = FF(a, b, c, d, M_offset_12, 7,  T[12]);
                d = FF(d, a, b, c, M_offset_13, 12, T[13]);
                c = FF(c, d, a, b, M_offset_14, 17, T[14]);
                b = FF(b, c, d, a, M_offset_15, 22, T[15]);

                a = GG(a, b, c, d, M_offset_1,  5,  T[16]);
                d = GG(d, a, b, c, M_offset_6,  9,  T[17]);
                c = GG(c, d, a, b, M_offset_11, 14, T[18]);
                b = GG(b, c, d, a, M_offset_0,  20, T[19]);
                a = GG(a, b, c, d, M_offset_5,  5,  T[20]);
                d = GG(d, a, b, c, M_offset_10, 9,  T[21]);
                c = GG(c, d, a, b, M_offset_15, 14, T[22]);
                b = GG(b, c, d, a, M_offset_4,  20, T[23]);
                a = GG(a, b, c, d, M_offset_9,  5,  T[24]);
                d = GG(d, a, b, c, M_offset_14, 9,  T[25]);
                c = GG(c, d, a, b, M_offset_3,  14, T[26]);
                b = GG(b, c, d, a, M_offset_8,  20, T[27]);
                a = GG(a, b, c, d, M_offset_13, 5,  T[28]);
                d = GG(d, a, b, c, M_offset_2,  9,  T[29]);
                c = GG(c, d, a, b, M_offset_7,  14, T[30]);
                b = GG(b, c, d, a, M_offset_12, 20, T[31]);

                a = HH(a, b, c, d, M_offset_5,  4,  T[32]);
                d = HH(d, a, b, c, M_offset_8,  11, T[33]);
                c = HH(c, d, a, b, M_offset_11, 16, T[34]);
                b = HH(b, c, d, a, M_offset_14, 23, T[35]);
                a = HH(a, b, c, d, M_offset_1,  4,  T[36]);
                d = HH(d, a, b, c, M_offset_4,  11, T[37]);
                c = HH(c, d, a, b, M_offset_7,  16, T[38]);
                b = HH(b, c, d, a, M_offset_10, 23, T[39]);
                a = HH(a, b, c, d, M_offset_13, 4,  T[40]);
                d = HH(d, a, b, c, M_offset_0,  11, T[41]);
                c = HH(c, d, a, b, M_offset_3,  16, T[42]);
                b = HH(b, c, d, a, M_offset_6,  23, T[43]);
                a = HH(a, b, c, d, M_offset_9,  4,  T[44]);
                d = HH(d, a, b, c, M_offset_12, 11, T[45]);
                c = HH(c, d, a, b, M_offset_15, 16, T[46]);
                b = HH(b, c, d, a, M_offset_2,  23, T[47]);

                a = II(a, b, c, d, M_offset_0,  6,  T[48]);
                d = II(d, a, b, c, M_offset_7,  10, T[49]);
                c = II(c, d, a, b, M_offset_14, 15, T[50]);
                b = II(b, c, d, a, M_offset_5,  21, T[51]);
                a = II(a, b, c, d, M_offset_12, 6,  T[52]);
                d = II(d, a, b, c, M_offset_3,  10, T[53]);
                c = II(c, d, a, b, M_offset_10, 15, T[54]);
                b = II(b, c, d, a, M_offset_1,  21, T[55]);
                a = II(a, b, c, d, M_offset_8,  6,  T[56]);
                d = II(d, a, b, c, M_offset_15, 10, T[57]);
                c = II(c, d, a, b, M_offset_6,  15, T[58]);
                b = II(b, c, d, a, M_offset_13, 21, T[59]);
                a = II(a, b, c, d, M_offset_4,  6,  T[60]);
                d = II(d, a, b, c, M_offset_11, 10, T[61]);
                c = II(c, d, a, b, M_offset_2,  15, T[62]);
                b = II(b, c, d, a, M_offset_9,  21, T[63]);

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);

                var nBitsTotalH = Math.floor(nBitsTotal / 0x100000000);
                var nBitsTotalL = nBitsTotal;
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = (
                    (((nBitsTotalH << 8)  | (nBitsTotalH >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotalH << 24) | (nBitsTotalH >>> 8))  & 0xff00ff00)
                );
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = (
                    (((nBitsTotalL << 8)  | (nBitsTotalL >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotalL << 24) | (nBitsTotalL >>> 8))  & 0xff00ff00)
                );

                data.sigBytes = (dataWords.length + 1) * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var hash = this._hash;
                var H = hash.words;

                // Swap endian
                for (var i = 0; i < 4; i++) {
                    // Shortcut
                    var H_i = H[i];

                    H[i] = (((H_i << 8)  | (H_i >>> 24)) & 0x00ff00ff) |
                        (((H_i << 24) | (H_i >>> 8))  & 0xff00ff00);
                }

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        function FF(a, b, c, d, x, s, t) {
            var n = a + ((b & c) | (~b & d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function GG(a, b, c, d, x, s, t) {
            var n = a + ((b & d) | (c & ~d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function HH(a, b, c, d, x, s, t) {
            var n = a + (b ^ c ^ d) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function II(a, b, c, d, x, s, t) {
            var n = a + (c ^ (b | ~d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.MD5('message');
         *     var hash = CryptoJS.MD5(wordArray);
         */
        C.MD5 = Hasher._createHelper(MD5);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacMD5(message, key);
         */
        C.HmacMD5 = Hasher._createHmacHelper(MD5);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Reusable object
        var W = [];

        /**
         * SHA-1 hash algorithm.
         */
        var SHA1 = C_algo.SHA1 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0x67452301, 0xefcdab89,
                    0x98badcfe, 0x10325476,
                    0xc3d2e1f0
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var H = this._hash.words;

                // Working variables
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];
                var e = H[4];

                // Computation
                for (var i = 0; i < 80; i++) {
                    if (i < 16) {
                        W[i] = M[offset + i] | 0;
                    } else {
                        var n = W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16];
                        W[i] = (n << 1) | (n >>> 31);
                    }

                    var t = ((a << 5) | (a >>> 27)) + e + W[i];
                    if (i < 20) {
                        t += ((b & c) | (~b & d)) + 0x5a827999;
                    } else if (i < 40) {
                        t += (b ^ c ^ d) + 0x6ed9eba1;
                    } else if (i < 60) {
                        t += ((b & c) | (b & d) | (c & d)) - 0x70e44324;
                    } else /* if (i < 80) */ {
                        t += (b ^ c ^ d) - 0x359d3e2a;
                    }

                    e = d;
                    d = c;
                    c = (b << 30) | (b >>> 2);
                    b = a;
                    a = t;
                }

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
                H[4] = (H[4] + e) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Return final computed hash
                return this._hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA1('message');
         *     var hash = CryptoJS.SHA1(wordArray);
         */
        C.SHA1 = Hasher._createHelper(SHA1);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA1(message, key);
         */
        C.HmacSHA1 = Hasher._createHmacHelper(SHA1);
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Initialization and round constants tables
        var H = [];
        var K = [];

        // Compute constants
        (function () {
            function isPrime(n) {
                var sqrtN = Math.sqrt(n);
                for (var factor = 2; factor <= sqrtN; factor++) {
                    if (!(n % factor)) {
                        return false;
                    }
                }

                return true;
            }

            function getFractionalBits(n) {
                return ((n - (n | 0)) * 0x100000000) | 0;
            }

            var n = 2;
            var nPrime = 0;
            while (nPrime < 64) {
                if (isPrime(n)) {
                    if (nPrime < 8) {
                        H[nPrime] = getFractionalBits(Math.pow(n, 1 / 2));
                    }
                    K[nPrime] = getFractionalBits(Math.pow(n, 1 / 3));

                    nPrime++;
                }

                n++;
            }
        }());

        // Reusable object
        var W = [];

        /**
         * SHA-256 hash algorithm.
         */
        var SHA256 = C_algo.SHA256 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init(H.slice(0));
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var H = this._hash.words;

                // Working variables
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];
                var e = H[4];
                var f = H[5];
                var g = H[6];
                var h = H[7];

                // Computation
                for (var i = 0; i < 64; i++) {
                    if (i < 16) {
                        W[i] = M[offset + i] | 0;
                    } else {
                        var gamma0x = W[i - 15];
                        var gamma0  = ((gamma0x << 25) | (gamma0x >>> 7))  ^
                            ((gamma0x << 14) | (gamma0x >>> 18)) ^
                            (gamma0x >>> 3);

                        var gamma1x = W[i - 2];
                        var gamma1  = ((gamma1x << 15) | (gamma1x >>> 17)) ^
                            ((gamma1x << 13) | (gamma1x >>> 19)) ^
                            (gamma1x >>> 10);

                        W[i] = gamma0 + W[i - 7] + gamma1 + W[i - 16];
                    }

                    var ch  = (e & f) ^ (~e & g);
                    var maj = (a & b) ^ (a & c) ^ (b & c);

                    var sigma0 = ((a << 30) | (a >>> 2)) ^ ((a << 19) | (a >>> 13)) ^ ((a << 10) | (a >>> 22));
                    var sigma1 = ((e << 26) | (e >>> 6)) ^ ((e << 21) | (e >>> 11)) ^ ((e << 7)  | (e >>> 25));

                    var t1 = h + sigma1 + ch + K[i] + W[i];
                    var t2 = sigma0 + maj;

                    h = g;
                    g = f;
                    f = e;
                    e = (d + t1) | 0;
                    d = c;
                    c = b;
                    b = a;
                    a = (t1 + t2) | 0;
                }

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
                H[4] = (H[4] + e) | 0;
                H[5] = (H[5] + f) | 0;
                H[6] = (H[6] + g) | 0;
                H[7] = (H[7] + h) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Return final computed hash
                return this._hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA256('message');
         *     var hash = CryptoJS.SHA256(wordArray);
         */
        C.SHA256 = Hasher._createHelper(SHA256);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA256(message, key);
         */
        C.HmacSHA256 = Hasher._createHmacHelper(SHA256);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_enc = C.enc;

        /**
         * UTF-16 BE encoding strategy.
         */
        var Utf16BE = C_enc.Utf16 = C_enc.Utf16BE = {
            /**
             * Converts a word array to a UTF-16 BE string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-16 BE string.
             *
             * @static
             *
             * @example
             *
             *     var utf16String = CryptoJS.enc.Utf16.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var utf16Chars = [];
                for (var i = 0; i < sigBytes; i += 2) {
                    var codePoint = (words[i >>> 2] >>> (16 - (i % 4) * 8)) & 0xffff;
                    utf16Chars.push(String.fromCharCode(codePoint));
                }

                return utf16Chars.join('');
            },

            /**
             * Converts a UTF-16 BE string to a word array.
             *
             * @param {string} utf16Str The UTF-16 BE string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf16.parse(utf16String);
             */
            parse: function (utf16Str) {
                // Shortcut
                var utf16StrLength = utf16Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < utf16StrLength; i++) {
                    words[i >>> 1] |= utf16Str.charCodeAt(i) << (16 - (i % 2) * 16);
                }

                return WordArray.create(words, utf16StrLength * 2);
            }
        };

        /**
         * UTF-16 LE encoding strategy.
         */
        C_enc.Utf16LE = {
            /**
             * Converts a word array to a UTF-16 LE string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-16 LE string.
             *
             * @static
             *
             * @example
             *
             *     var utf16Str = CryptoJS.enc.Utf16LE.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var utf16Chars = [];
                for (var i = 0; i < sigBytes; i += 2) {
                    var codePoint = swapEndian((words[i >>> 2] >>> (16 - (i % 4) * 8)) & 0xffff);
                    utf16Chars.push(String.fromCharCode(codePoint));
                }

                return utf16Chars.join('');
            },

            /**
             * Converts a UTF-16 LE string to a word array.
             *
             * @param {string} utf16Str The UTF-16 LE string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf16LE.parse(utf16Str);
             */
            parse: function (utf16Str) {
                // Shortcut
                var utf16StrLength = utf16Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < utf16StrLength; i++) {
                    words[i >>> 1] |= swapEndian(utf16Str.charCodeAt(i) << (16 - (i % 2) * 16));
                }

                return WordArray.create(words, utf16StrLength * 2);
            }
        };

        function swapEndian(word) {
            return ((word << 8) & 0xff00ff00) | ((word >>> 8) & 0x00ff00ff);
        }
    }());


    (function () {
        // Check if typed arrays are supported
        if (typeof ArrayBuffer != 'function') {
            return;
        }

        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;

        // Reference original init
        var superInit = WordArray.init;

        // Augment WordArray.init to handle typed arrays
        var subInit = WordArray.init = function (typedArray) {
            // Convert buffers to uint8
            if (typedArray instanceof ArrayBuffer) {
                typedArray = new Uint8Array(typedArray);
            }

            // Convert other array views to uint8
            if (
                typedArray instanceof Int8Array ||
                (typeof Uint8ClampedArray !== "undefined" && typedArray instanceof Uint8ClampedArray) ||
                typedArray instanceof Int16Array ||
                typedArray instanceof Uint16Array ||
                typedArray instanceof Int32Array ||
                typedArray instanceof Uint32Array ||
                typedArray instanceof Float32Array ||
                typedArray instanceof Float64Array
            ) {
                typedArray = new Uint8Array(typedArray.buffer, typedArray.byteOffset, typedArray.byteLength);
            }

            // Handle Uint8Array
            if (typedArray instanceof Uint8Array) {
                // Shortcut
                var typedArrayByteLength = typedArray.byteLength;

                // Extract bytes
                var words = [];
                for (var i = 0; i < typedArrayByteLength; i++) {
                    words[i >>> 2] |= typedArray[i] << (24 - (i % 4) * 8);
                }

                // Initialize this word array
                superInit.call(this, words, typedArrayByteLength);
            } else {
                // Else call normal init
                superInit.apply(this, arguments);
            }
        };

        subInit.prototype = WordArray;
    }());


    /** @preserve
     (c) 2012 by Cédric Mesnil. All rights reserved.

     Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

     - Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
     - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

     THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
     */

    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Constants table
        var _zl = WordArray.create([
            0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15,
            7,  4, 13,  1, 10,  6, 15,  3, 12,  0,  9,  5,  2, 14, 11,  8,
            3, 10, 14,  4,  9, 15,  8,  1,  2,  7,  0,  6, 13, 11,  5, 12,
            1,  9, 11, 10,  0,  8, 12,  4, 13,  3,  7, 15, 14,  5,  6,  2,
            4,  0,  5,  9,  7, 12,  2, 10, 14,  1,  3,  8, 11,  6, 15, 13]);
        var _zr = WordArray.create([
            5, 14,  7,  0,  9,  2, 11,  4, 13,  6, 15,  8,  1, 10,  3, 12,
            6, 11,  3,  7,  0, 13,  5, 10, 14, 15,  8, 12,  4,  9,  1,  2,
            15,  5,  1,  3,  7, 14,  6,  9, 11,  8, 12,  2, 10,  0,  4, 13,
            8,  6,  4,  1,  3, 11, 15,  0,  5, 12,  2, 13,  9,  7, 10, 14,
            12, 15, 10,  4,  1,  5,  8,  7,  6,  2, 13, 14,  0,  3,  9, 11]);
        var _sl = WordArray.create([
            11, 14, 15, 12,  5,  8,  7,  9, 11, 13, 14, 15,  6,  7,  9,  8,
            7, 6,   8, 13, 11,  9,  7, 15,  7, 12, 15,  9, 11,  7, 13, 12,
            11, 13,  6,  7, 14,  9, 13, 15, 14,  8, 13,  6,  5, 12,  7,  5,
            11, 12, 14, 15, 14, 15,  9,  8,  9, 14,  5,  6,  8,  6,  5, 12,
            9, 15,  5, 11,  6,  8, 13, 12,  5, 12, 13, 14, 11,  8,  5,  6 ]);
        var _sr = WordArray.create([
            8,  9,  9, 11, 13, 15, 15,  5,  7,  7,  8, 11, 14, 14, 12,  6,
            9, 13, 15,  7, 12,  8,  9, 11,  7,  7, 12,  7,  6, 15, 13, 11,
            9,  7, 15, 11,  8,  6,  6, 14, 12, 13,  5, 14, 13, 13,  7,  5,
            15,  5,  8, 11, 14, 14,  6, 14,  6,  9, 12,  9, 12,  5, 15,  8,
            8,  5, 12,  9, 12,  5, 14,  6,  8, 13,  6,  5, 15, 13, 11, 11 ]);

        var _hl =  WordArray.create([ 0x00000000, 0x5A827999, 0x6ED9EBA1, 0x8F1BBCDC, 0xA953FD4E]);
        var _hr =  WordArray.create([ 0x50A28BE6, 0x5C4DD124, 0x6D703EF3, 0x7A6D76E9, 0x00000000]);

        /**
         * RIPEMD160 hash algorithm.
         */
        var RIPEMD160 = C_algo.RIPEMD160 = Hasher.extend({
            _doReset: function () {
                this._hash  = WordArray.create([0x67452301, 0xEFCDAB89, 0x98BADCFE, 0x10325476, 0xC3D2E1F0]);
            },

            _doProcessBlock: function (M, offset) {

                // Swap endian
                for (var i = 0; i < 16; i++) {
                    // Shortcuts
                    var offset_i = offset + i;
                    var M_offset_i = M[offset_i];

                    // Swap
                    M[offset_i] = (
                        (((M_offset_i << 8)  | (M_offset_i >>> 24)) & 0x00ff00ff) |
                        (((M_offset_i << 24) | (M_offset_i >>> 8))  & 0xff00ff00)
                    );
                }
                // Shortcut
                var H  = this._hash.words;
                var hl = _hl.words;
                var hr = _hr.words;
                var zl = _zl.words;
                var zr = _zr.words;
                var sl = _sl.words;
                var sr = _sr.words;

                // Working variables
                var al, bl, cl, dl, el;
                var ar, br, cr, dr, er;

                ar = al = H[0];
                br = bl = H[1];
                cr = cl = H[2];
                dr = dl = H[3];
                er = el = H[4];
                // Computation
                var t;
                for (var i = 0; i < 80; i += 1) {
                    t = (al +  M[offset+zl[i]])|0;
                    if (i<16){
                        t +=  f1(bl,cl,dl) + hl[0];
                    } else if (i<32) {
                        t +=  f2(bl,cl,dl) + hl[1];
                    } else if (i<48) {
                        t +=  f3(bl,cl,dl) + hl[2];
                    } else if (i<64) {
                        t +=  f4(bl,cl,dl) + hl[3];
                    } else {// if (i<80) {
                        t +=  f5(bl,cl,dl) + hl[4];
                    }
                    t = t|0;
                    t =  rotl(t,sl[i]);
                    t = (t+el)|0;
                    al = el;
                    el = dl;
                    dl = rotl(cl, 10);
                    cl = bl;
                    bl = t;

                    t = (ar + M[offset+zr[i]])|0;
                    if (i<16){
                        t +=  f5(br,cr,dr) + hr[0];
                    } else if (i<32) {
                        t +=  f4(br,cr,dr) + hr[1];
                    } else if (i<48) {
                        t +=  f3(br,cr,dr) + hr[2];
                    } else if (i<64) {
                        t +=  f2(br,cr,dr) + hr[3];
                    } else {// if (i<80) {
                        t +=  f1(br,cr,dr) + hr[4];
                    }
                    t = t|0;
                    t =  rotl(t,sr[i]) ;
                    t = (t+er)|0;
                    ar = er;
                    er = dr;
                    dr = rotl(cr, 10);
                    cr = br;
                    br = t;
                }
                // Intermediate hash value
                t    = (H[1] + cl + dr)|0;
                H[1] = (H[2] + dl + er)|0;
                H[2] = (H[3] + el + ar)|0;
                H[3] = (H[4] + al + br)|0;
                H[4] = (H[0] + bl + cr)|0;
                H[0] =  t;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = (
                    (((nBitsTotal << 8)  | (nBitsTotal >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotal << 24) | (nBitsTotal >>> 8))  & 0xff00ff00)
                );
                data.sigBytes = (dataWords.length + 1) * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var hash = this._hash;
                var H = hash.words;

                // Swap endian
                for (var i = 0; i < 5; i++) {
                    // Shortcut
                    var H_i = H[i];

                    // Swap
                    H[i] = (((H_i << 8)  | (H_i >>> 24)) & 0x00ff00ff) |
                        (((H_i << 24) | (H_i >>> 8))  & 0xff00ff00);
                }

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });


        function f1(x, y, z) {
            return ((x) ^ (y) ^ (z));

        }

        function f2(x, y, z) {
            return (((x)&(y)) | ((~x)&(z)));
        }

        function f3(x, y, z) {
            return (((x) | (~(y))) ^ (z));
        }

        function f4(x, y, z) {
            return (((x) & (z)) | ((y)&(~(z))));
        }

        function f5(x, y, z) {
            return ((x) ^ ((y) |(~(z))));

        }

        function rotl(x,n) {
            return (x<<n) | (x>>>(32-n));
        }


        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.RIPEMD160('message');
         *     var hash = CryptoJS.RIPEMD160(wordArray);
         */
        C.RIPEMD160 = Hasher._createHelper(RIPEMD160);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacRIPEMD160(message, key);
         */
        C.HmacRIPEMD160 = Hasher._createHmacHelper(RIPEMD160);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var C_enc = C.enc;
        var Utf8 = C_enc.Utf8;
        var C_algo = C.algo;

        /**
         * HMAC algorithm.
         */
        var HMAC = C_algo.HMAC = Base.extend({
            /**
             * Initializes a newly created HMAC.
             *
             * @param {Hasher} hasher The hash algorithm to use.
             * @param {WordArray|string} key The secret key.
             *
             * @example
             *
             *     var hmacHasher = CryptoJS.algo.HMAC.create(CryptoJS.algo.SHA256, key);
             */
            init: function (hasher, key) {
                // Init hasher
                hasher = this._hasher = new hasher.init();

                // Convert string to WordArray, else assume WordArray already
                if (typeof key == 'string') {
                    key = Utf8.parse(key);
                }

                // Shortcuts
                var hasherBlockSize = hasher.blockSize;
                var hasherBlockSizeBytes = hasherBlockSize * 4;

                // Allow arbitrary length keys
                if (key.sigBytes > hasherBlockSizeBytes) {
                    key = hasher.finalize(key);
                }

                // Clamp excess bits
                key.clamp();

                // Clone key for inner and outer pads
                var oKey = this._oKey = key.clone();
                var iKey = this._iKey = key.clone();

                // Shortcuts
                var oKeyWords = oKey.words;
                var iKeyWords = iKey.words;

                // XOR keys with pad constants
                for (var i = 0; i < hasherBlockSize; i++) {
                    oKeyWords[i] ^= 0x5c5c5c5c;
                    iKeyWords[i] ^= 0x36363636;
                }
                oKey.sigBytes = iKey.sigBytes = hasherBlockSizeBytes;

                // Set initial values
                this.reset();
            },

            /**
             * Resets this HMAC to its initial state.
             *
             * @example
             *
             *     hmacHasher.reset();
             */
            reset: function () {
                // Shortcut
                var hasher = this._hasher;

                // Reset
                hasher.reset();
                hasher.update(this._iKey);
            },

            /**
             * Updates this HMAC with a message.
             *
             * @param {WordArray|string} messageUpdate The message to append.
             *
             * @return {HMAC} This HMAC instance.
             *
             * @example
             *
             *     hmacHasher.update('message');
             *     hmacHasher.update(wordArray);
             */
            update: function (messageUpdate) {
                this._hasher.update(messageUpdate);

                // Chainable
                return this;
            },

            /**
             * Finalizes the HMAC computation.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} messageUpdate (Optional) A final message update.
             *
             * @return {WordArray} The HMAC.
             *
             * @example
             *
             *     var hmac = hmacHasher.finalize();
             *     var hmac = hmacHasher.finalize('message');
             *     var hmac = hmacHasher.finalize(wordArray);
             */
            finalize: function (messageUpdate) {
                // Shortcut
                var hasher = this._hasher;

                // Compute HMAC
                var innerHash = hasher.finalize(messageUpdate);
                hasher.reset();
                var hmac = hasher.finalize(this._oKey.clone().concat(innerHash));

                return hmac;
            }
        });
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var SHA1 = C_algo.SHA1;
        var HMAC = C_algo.HMAC;

        /**
         * Password-Based Key Derivation Function 2 algorithm.
         */
        var PBKDF2 = C_algo.PBKDF2 = Base.extend({
            /**
             * Configuration options.
             *
             * @property {number} keySize The key size in words to generate. Default: 4 (128 bits)
             * @property {Hasher} hasher The hasher to use. Default: SHA1
             * @property {number} iterations The number of iterations to perform. Default: 1
             */
            cfg: Base.extend({
                keySize: 128/32,
                hasher: SHA1,
                iterations: 1
            }),

            /**
             * Initializes a newly created key derivation function.
             *
             * @param {Object} cfg (Optional) The configuration options to use for the derivation.
             *
             * @example
             *
             *     var kdf = CryptoJS.algo.PBKDF2.create();
             *     var kdf = CryptoJS.algo.PBKDF2.create({ keySize: 8 });
             *     var kdf = CryptoJS.algo.PBKDF2.create({ keySize: 8, iterations: 1000 });
             */
            init: function (cfg) {
                this.cfg = this.cfg.extend(cfg);
            },

            /**
             * Computes the Password-Based Key Derivation Function 2.
             *
             * @param {WordArray|string} password The password.
             * @param {WordArray|string} salt A salt.
             *
             * @return {WordArray} The derived key.
             *
             * @example
             *
             *     var key = kdf.compute(password, salt);
             */
            compute: function (password, salt) {
                // Shortcut
                var cfg = this.cfg;

                // Init HMAC
                var hmac = HMAC.create(cfg.hasher, password);

                // Initial values
                var derivedKey = WordArray.create();
                var blockIndex = WordArray.create([0x00000001]);

                // Shortcuts
                var derivedKeyWords = derivedKey.words;
                var blockIndexWords = blockIndex.words;
                var keySize = cfg.keySize;
                var iterations = cfg.iterations;

                // Generate key
                while (derivedKeyWords.length < keySize) {
                    var block = hmac.update(salt).finalize(blockIndex);
                    hmac.reset();

                    // Shortcuts
                    var blockWords = block.words;
                    var blockWordsLength = blockWords.length;

                    // Iterations
                    var intermediate = block;
                    for (var i = 1; i < iterations; i++) {
                        intermediate = hmac.finalize(intermediate);
                        hmac.reset();

                        // Shortcut
                        var intermediateWords = intermediate.words;

                        // XOR intermediate with block
                        for (var j = 0; j < blockWordsLength; j++) {
                            blockWords[j] ^= intermediateWords[j];
                        }
                    }

                    derivedKey.concat(block);
                    blockIndexWords[0]++;
                }
                derivedKey.sigBytes = keySize * 4;

                return derivedKey;
            }
        });

        /**
         * Computes the Password-Based Key Derivation Function 2.
         *
         * @param {WordArray|string} password The password.
         * @param {WordArray|string} salt A salt.
         * @param {Object} cfg (Optional) The configuration options to use for this computation.
         *
         * @return {WordArray} The derived key.
         *
         * @static
         *
         * @example
         *
         *     var key = CryptoJS.PBKDF2(password, salt);
         *     var key = CryptoJS.PBKDF2(password, salt, { keySize: 8 });
         *     var key = CryptoJS.PBKDF2(password, salt, { keySize: 8, iterations: 1000 });
         */
        C.PBKDF2 = function (password, salt, cfg) {
            return PBKDF2.create(cfg).compute(password, salt);
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var MD5 = C_algo.MD5;

        /**
         * This key derivation function is meant to conform with EVP_BytesToKey.
         * www.openssl.org/docs/crypto/EVP_BytesToKey.html
         */
        var EvpKDF = C_algo.EvpKDF = Base.extend({
            /**
             * Configuration options.
             *
             * @property {number} keySize The key size in words to generate. Default: 4 (128 bits)
             * @property {Hasher} hasher The hash algorithm to use. Default: MD5
             * @property {number} iterations The number of iterations to perform. Default: 1
             */
            cfg: Base.extend({
                keySize: 128/32,
                hasher: MD5,
                iterations: 1
            }),

            /**
             * Initializes a newly created key derivation function.
             *
             * @param {Object} cfg (Optional) The configuration options to use for the derivation.
             *
             * @example
             *
             *     var kdf = CryptoJS.algo.EvpKDF.create();
             *     var kdf = CryptoJS.algo.EvpKDF.create({ keySize: 8 });
             *     var kdf = CryptoJS.algo.EvpKDF.create({ keySize: 8, iterations: 1000 });
             */
            init: function (cfg) {
                this.cfg = this.cfg.extend(cfg);
            },

            /**
             * Derives a key from a password.
             *
             * @param {WordArray|string} password The password.
             * @param {WordArray|string} salt A salt.
             *
             * @return {WordArray} The derived key.
             *
             * @example
             *
             *     var key = kdf.compute(password, salt);
             */
            compute: function (password, salt) {
                // Shortcut
                var cfg = this.cfg;

                // Init hasher
                var hasher = cfg.hasher.create();

                // Initial values
                var derivedKey = WordArray.create();

                // Shortcuts
                var derivedKeyWords = derivedKey.words;
                var keySize = cfg.keySize;
                var iterations = cfg.iterations;

                // Generate key
                while (derivedKeyWords.length < keySize) {
                    if (block) {
                        hasher.update(block);
                    }
                    var block = hasher.update(password).finalize(salt);
                    hasher.reset();

                    // Iterations
                    for (var i = 1; i < iterations; i++) {
                        block = hasher.finalize(block);
                        hasher.reset();
                    }

                    derivedKey.concat(block);
                }
                derivedKey.sigBytes = keySize * 4;

                return derivedKey;
            }
        });

        /**
         * Derives a key from a password.
         *
         * @param {WordArray|string} password The password.
         * @param {WordArray|string} salt A salt.
         * @param {Object} cfg (Optional) The configuration options to use for this computation.
         *
         * @return {WordArray} The derived key.
         *
         * @static
         *
         * @example
         *
         *     var key = CryptoJS.EvpKDF(password, salt);
         *     var key = CryptoJS.EvpKDF(password, salt, { keySize: 8 });
         *     var key = CryptoJS.EvpKDF(password, salt, { keySize: 8, iterations: 1000 });
         */
        C.EvpKDF = function (password, salt, cfg) {
            return EvpKDF.create(cfg).compute(password, salt);
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var SHA256 = C_algo.SHA256;

        /**
         * SHA-224 hash algorithm.
         */
        var SHA224 = C_algo.SHA224 = SHA256.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0xc1059ed8, 0x367cd507, 0x3070dd17, 0xf70e5939,
                    0xffc00b31, 0x68581511, 0x64f98fa7, 0xbefa4fa4
                ]);
            },

            _doFinalize: function () {
                var hash = SHA256._doFinalize.call(this);

                hash.sigBytes -= 4;

                return hash;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA224('message');
         *     var hash = CryptoJS.SHA224(wordArray);
         */
        C.SHA224 = SHA256._createHelper(SHA224);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA224(message, key);
         */
        C.HmacSHA224 = SHA256._createHmacHelper(SHA224);
    }());


    (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var X32WordArray = C_lib.WordArray;

        /**
         * x64 namespace.
         */
        var C_x64 = C.x64 = {};

        /**
         * A 64-bit word.
         */
        var X64Word = C_x64.Word = Base.extend({
            /**
             * Initializes a newly created 64-bit word.
             *
             * @param {number} high The high 32 bits.
             * @param {number} low The low 32 bits.
             *
             * @example
             *
             *     var x64Word = CryptoJS.x64.Word.create(0x00010203, 0x04050607);
             */
            init: function (high, low) {
                this.high = high;
                this.low = low;
            }

            /**
             * Bitwise NOTs this word.
             *
             * @return {X64Word} A new x64-Word object after negating.
             *
             * @example
             *
             *     var negated = x64Word.not();
             */
            // not: function () {
            // var high = ~this.high;
            // var low = ~this.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise ANDs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to AND with this word.
             *
             * @return {X64Word} A new x64-Word object after ANDing.
             *
             * @example
             *
             *     var anded = x64Word.and(anotherX64Word);
             */
            // and: function (word) {
            // var high = this.high & word.high;
            // var low = this.low & word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise ORs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to OR with this word.
             *
             * @return {X64Word} A new x64-Word object after ORing.
             *
             * @example
             *
             *     var ored = x64Word.or(anotherX64Word);
             */
            // or: function (word) {
            // var high = this.high | word.high;
            // var low = this.low | word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise XORs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to XOR with this word.
             *
             * @return {X64Word} A new x64-Word object after XORing.
             *
             * @example
             *
             *     var xored = x64Word.xor(anotherX64Word);
             */
            // xor: function (word) {
            // var high = this.high ^ word.high;
            // var low = this.low ^ word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Shifts this word n bits to the left.
             *
             * @param {number} n The number of bits to shift.
             *
             * @return {X64Word} A new x64-Word object after shifting.
             *
             * @example
             *
             *     var shifted = x64Word.shiftL(25);
             */
            // shiftL: function (n) {
            // if (n < 32) {
            // var high = (this.high << n) | (this.low >>> (32 - n));
            // var low = this.low << n;
            // } else {
            // var high = this.low << (n - 32);
            // var low = 0;
            // }

            // return X64Word.create(high, low);
            // },

            /**
             * Shifts this word n bits to the right.
             *
             * @param {number} n The number of bits to shift.
             *
             * @return {X64Word} A new x64-Word object after shifting.
             *
             * @example
             *
             *     var shifted = x64Word.shiftR(7);
             */
            // shiftR: function (n) {
            // if (n < 32) {
            // var low = (this.low >>> n) | (this.high << (32 - n));
            // var high = this.high >>> n;
            // } else {
            // var low = this.high >>> (n - 32);
            // var high = 0;
            // }

            // return X64Word.create(high, low);
            // },

            /**
             * Rotates this word n bits to the left.
             *
             * @param {number} n The number of bits to rotate.
             *
             * @return {X64Word} A new x64-Word object after rotating.
             *
             * @example
             *
             *     var rotated = x64Word.rotL(25);
             */
            // rotL: function (n) {
            // return this.shiftL(n).or(this.shiftR(64 - n));
            // },

            /**
             * Rotates this word n bits to the right.
             *
             * @param {number} n The number of bits to rotate.
             *
             * @return {X64Word} A new x64-Word object after rotating.
             *
             * @example
             *
             *     var rotated = x64Word.rotR(7);
             */
            // rotR: function (n) {
            // return this.shiftR(n).or(this.shiftL(64 - n));
            // },

            /**
             * Adds this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to add with this word.
             *
             * @return {X64Word} A new x64-Word object after adding.
             *
             * @example
             *
             *     var added = x64Word.add(anotherX64Word);
             */
            // add: function (word) {
            // var low = (this.low + word.low) | 0;
            // var carry = (low >>> 0) < (this.low >>> 0) ? 1 : 0;
            // var high = (this.high + word.high + carry) | 0;

            // return X64Word.create(high, low);
            // }
        });

        /**
         * An array of 64-bit words.
         *
         * @property {Array} words The array of CryptoJS.x64.Word objects.
         * @property {number} sigBytes The number of significant bytes in this word array.
         */
        var X64WordArray = C_x64.WordArray = Base.extend({
            /**
             * Initializes a newly created word array.
             *
             * @param {Array} words (Optional) An array of CryptoJS.x64.Word objects.
             * @param {number} sigBytes (Optional) The number of significant bytes in the words.
             *
             * @example
             *
             *     var wordArray = CryptoJS.x64.WordArray.create();
             *
             *     var wordArray = CryptoJS.x64.WordArray.create([
             *         CryptoJS.x64.Word.create(0x00010203, 0x04050607),
             *         CryptoJS.x64.Word.create(0x18191a1b, 0x1c1d1e1f)
             *     ]);
             *
             *     var wordArray = CryptoJS.x64.WordArray.create([
             *         CryptoJS.x64.Word.create(0x00010203, 0x04050607),
             *         CryptoJS.x64.Word.create(0x18191a1b, 0x1c1d1e1f)
             *     ], 10);
             */
            init: function (words, sigBytes) {
                words = this.words = words || [];

                if (sigBytes != undefined) {
                    this.sigBytes = sigBytes;
                } else {
                    this.sigBytes = words.length * 8;
                }
            },

            /**
             * Converts this 64-bit word array to a 32-bit word array.
             *
             * @return {CryptoJS.lib.WordArray} This word array's data as a 32-bit word array.
             *
             * @example
             *
             *     var x32WordArray = x64WordArray.toX32();
             */
            toX32: function () {
                // Shortcuts
                var x64Words = this.words;
                var x64WordsLength = x64Words.length;

                // Convert
                var x32Words = [];
                for (var i = 0; i < x64WordsLength; i++) {
                    var x64Word = x64Words[i];
                    x32Words.push(x64Word.high);
                    x32Words.push(x64Word.low);
                }

                return X32WordArray.create(x32Words, this.sigBytes);
            },

            /**
             * Creates a copy of this word array.
             *
             * @return {X64WordArray} The clone.
             *
             * @example
             *
             *     var clone = x64WordArray.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);

                // Clone "words" array
                var words = clone.words = this.words.slice(0);

                // Clone each X64Word object
                var wordsLength = words.length;
                for (var i = 0; i < wordsLength; i++) {
                    words[i] = words[i].clone();
                }

                return clone;
            }
        });
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var C_algo = C.algo;

        // Constants tables
        var RHO_OFFSETS = [];
        var PI_INDEXES  = [];
        var ROUND_CONSTANTS = [];

        // Compute Constants
        (function () {
            // Compute rho offset constants
            var x = 1, y = 0;
            for (var t = 0; t < 24; t++) {
                RHO_OFFSETS[x + 5 * y] = ((t + 1) * (t + 2) / 2) % 64;

                var newX = y % 5;
                var newY = (2 * x + 3 * y) % 5;
                x = newX;
                y = newY;
            }

            // Compute pi index constants
            for (var x = 0; x < 5; x++) {
                for (var y = 0; y < 5; y++) {
                    PI_INDEXES[x + 5 * y] = y + ((2 * x + 3 * y) % 5) * 5;
                }
            }

            // Compute round constants
            var LFSR = 0x01;
            for (var i = 0; i < 24; i++) {
                var roundConstantMsw = 0;
                var roundConstantLsw = 0;

                for (var j = 0; j < 7; j++) {
                    if (LFSR & 0x01) {
                        var bitPosition = (1 << j) - 1;
                        if (bitPosition < 32) {
                            roundConstantLsw ^= 1 << bitPosition;
                        } else /* if (bitPosition >= 32) */ {
                            roundConstantMsw ^= 1 << (bitPosition - 32);
                        }
                    }

                    // Compute next LFSR
                    if (LFSR & 0x80) {
                        // Primitive polynomial over GF(2): x^8 + x^6 + x^5 + x^4 + 1
                        LFSR = (LFSR << 1) ^ 0x71;
                    } else {
                        LFSR <<= 1;
                    }
                }

                ROUND_CONSTANTS[i] = X64Word.create(roundConstantMsw, roundConstantLsw);
            }
        }());

        // Reusable objects for temporary values
        var T = [];
        (function () {
            for (var i = 0; i < 25; i++) {
                T[i] = X64Word.create();
            }
        }());

        /**
         * SHA-3 hash algorithm.
         */
        var SHA3 = C_algo.SHA3 = Hasher.extend({
            /**
             * Configuration options.
             *
             * @property {number} outputLength
             *   The desired number of bits in the output hash.
             *   Only values permitted are: 224, 256, 384, 512.
             *   Default: 512
             */
            cfg: Hasher.cfg.extend({
                outputLength: 512
            }),

            _doReset: function () {
                var state = this._state = []
                for (var i = 0; i < 25; i++) {
                    state[i] = new X64Word.init();
                }

                this.blockSize = (1600 - 2 * this.cfg.outputLength) / 32;
            },

            _doProcessBlock: function (M, offset) {
                // Shortcuts
                var state = this._state;
                var nBlockSizeLanes = this.blockSize / 2;

                // Absorb
                for (var i = 0; i < nBlockSizeLanes; i++) {
                    // Shortcuts
                    var M2i  = M[offset + 2 * i];
                    var M2i1 = M[offset + 2 * i + 1];

                    // Swap endian
                    M2i = (
                        (((M2i << 8)  | (M2i >>> 24)) & 0x00ff00ff) |
                        (((M2i << 24) | (M2i >>> 8))  & 0xff00ff00)
                    );
                    M2i1 = (
                        (((M2i1 << 8)  | (M2i1 >>> 24)) & 0x00ff00ff) |
                        (((M2i1 << 24) | (M2i1 >>> 8))  & 0xff00ff00)
                    );

                    // Absorb message into state
                    var lane = state[i];
                    lane.high ^= M2i1;
                    lane.low  ^= M2i;
                }

                // Rounds
                for (var round = 0; round < 24; round++) {
                    // Theta
                    for (var x = 0; x < 5; x++) {
                        // Mix column lanes
                        var tMsw = 0, tLsw = 0;
                        for (var y = 0; y < 5; y++) {
                            var lane = state[x + 5 * y];
                            tMsw ^= lane.high;
                            tLsw ^= lane.low;
                        }

                        // Temporary values
                        var Tx = T[x];
                        Tx.high = tMsw;
                        Tx.low  = tLsw;
                    }
                    for (var x = 0; x < 5; x++) {
                        // Shortcuts
                        var Tx4 = T[(x + 4) % 5];
                        var Tx1 = T[(x + 1) % 5];
                        var Tx1Msw = Tx1.high;
                        var Tx1Lsw = Tx1.low;

                        // Mix surrounding columns
                        var tMsw = Tx4.high ^ ((Tx1Msw << 1) | (Tx1Lsw >>> 31));
                        var tLsw = Tx4.low  ^ ((Tx1Lsw << 1) | (Tx1Msw >>> 31));
                        for (var y = 0; y < 5; y++) {
                            var lane = state[x + 5 * y];
                            lane.high ^= tMsw;
                            lane.low  ^= tLsw;
                        }
                    }

                    // Rho Pi
                    for (var laneIndex = 1; laneIndex < 25; laneIndex++) {
                        // Shortcuts
                        var lane = state[laneIndex];
                        var laneMsw = lane.high;
                        var laneLsw = lane.low;
                        var rhoOffset = RHO_OFFSETS[laneIndex];

                        // Rotate lanes
                        if (rhoOffset < 32) {
                            var tMsw = (laneMsw << rhoOffset) | (laneLsw >>> (32 - rhoOffset));
                            var tLsw = (laneLsw << rhoOffset) | (laneMsw >>> (32 - rhoOffset));
                        } else /* if (rhoOffset >= 32) */ {
                            var tMsw = (laneLsw << (rhoOffset - 32)) | (laneMsw >>> (64 - rhoOffset));
                            var tLsw = (laneMsw << (rhoOffset - 32)) | (laneLsw >>> (64 - rhoOffset));
                        }

                        // Transpose lanes
                        var TPiLane = T[PI_INDEXES[laneIndex]];
                        TPiLane.high = tMsw;
                        TPiLane.low  = tLsw;
                    }

                    // Rho pi at x = y = 0
                    var T0 = T[0];
                    var state0 = state[0];
                    T0.high = state0.high;
                    T0.low  = state0.low;

                    // Chi
                    for (var x = 0; x < 5; x++) {
                        for (var y = 0; y < 5; y++) {
                            // Shortcuts
                            var laneIndex = x + 5 * y;
                            var lane = state[laneIndex];
                            var TLane = T[laneIndex];
                            var Tx1Lane = T[((x + 1) % 5) + 5 * y];
                            var Tx2Lane = T[((x + 2) % 5) + 5 * y];

                            // Mix rows
                            lane.high = TLane.high ^ (~Tx1Lane.high & Tx2Lane.high);
                            lane.low  = TLane.low  ^ (~Tx1Lane.low  & Tx2Lane.low);
                        }
                    }

                    // Iota
                    var lane = state[0];
                    var roundConstant = ROUND_CONSTANTS[round];
                    lane.high ^= roundConstant.high;
                    lane.low  ^= roundConstant.low;;
                }
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;
                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;
                var blockSizeBits = this.blockSize * 32;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x1 << (24 - nBitsLeft % 32);
                dataWords[((Math.ceil((nBitsLeft + 1) / blockSizeBits) * blockSizeBits) >>> 5) - 1] |= 0x80;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var state = this._state;
                var outputLengthBytes = this.cfg.outputLength / 8;
                var outputLengthLanes = outputLengthBytes / 8;

                // Squeeze
                var hashWords = [];
                for (var i = 0; i < outputLengthLanes; i++) {
                    // Shortcuts
                    var lane = state[i];
                    var laneMsw = lane.high;
                    var laneLsw = lane.low;

                    // Swap endian
                    laneMsw = (
                        (((laneMsw << 8)  | (laneMsw >>> 24)) & 0x00ff00ff) |
                        (((laneMsw << 24) | (laneMsw >>> 8))  & 0xff00ff00)
                    );
                    laneLsw = (
                        (((laneLsw << 8)  | (laneLsw >>> 24)) & 0x00ff00ff) |
                        (((laneLsw << 24) | (laneLsw >>> 8))  & 0xff00ff00)
                    );

                    // Squeeze state to retrieve hash
                    hashWords.push(laneLsw);
                    hashWords.push(laneMsw);
                }

                // Return final computed hash
                return new WordArray.init(hashWords, outputLengthBytes);
            },

            clone: function () {
                var clone = Hasher.clone.call(this);

                var state = clone._state = this._state.slice(0);
                for (var i = 0; i < 25; i++) {
                    state[i] = state[i].clone();
                }

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA3('message');
         *     var hash = CryptoJS.SHA3(wordArray);
         */
        C.SHA3 = Hasher._createHelper(SHA3);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA3(message, key);
         */
        C.HmacSHA3 = Hasher._createHmacHelper(SHA3);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Hasher = C_lib.Hasher;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var X64WordArray = C_x64.WordArray;
        var C_algo = C.algo;

        function X64Word_create() {
            return X64Word.create.apply(X64Word, arguments);
        }

        // Constants
        var K = [
            X64Word_create(0x428a2f98, 0xd728ae22), X64Word_create(0x71374491, 0x23ef65cd),
            X64Word_create(0xb5c0fbcf, 0xec4d3b2f), X64Word_create(0xe9b5dba5, 0x8189dbbc),
            X64Word_create(0x3956c25b, 0xf348b538), X64Word_create(0x59f111f1, 0xb605d019),
            X64Word_create(0x923f82a4, 0xaf194f9b), X64Word_create(0xab1c5ed5, 0xda6d8118),
            X64Word_create(0xd807aa98, 0xa3030242), X64Word_create(0x12835b01, 0x45706fbe),
            X64Word_create(0x243185be, 0x4ee4b28c), X64Word_create(0x550c7dc3, 0xd5ffb4e2),
            X64Word_create(0x72be5d74, 0xf27b896f), X64Word_create(0x80deb1fe, 0x3b1696b1),
            X64Word_create(0x9bdc06a7, 0x25c71235), X64Word_create(0xc19bf174, 0xcf692694),
            X64Word_create(0xe49b69c1, 0x9ef14ad2), X64Word_create(0xefbe4786, 0x384f25e3),
            X64Word_create(0x0fc19dc6, 0x8b8cd5b5), X64Word_create(0x240ca1cc, 0x77ac9c65),
            X64Word_create(0x2de92c6f, 0x592b0275), X64Word_create(0x4a7484aa, 0x6ea6e483),
            X64Word_create(0x5cb0a9dc, 0xbd41fbd4), X64Word_create(0x76f988da, 0x831153b5),
            X64Word_create(0x983e5152, 0xee66dfab), X64Word_create(0xa831c66d, 0x2db43210),
            X64Word_create(0xb00327c8, 0x98fb213f), X64Word_create(0xbf597fc7, 0xbeef0ee4),
            X64Word_create(0xc6e00bf3, 0x3da88fc2), X64Word_create(0xd5a79147, 0x930aa725),
            X64Word_create(0x06ca6351, 0xe003826f), X64Word_create(0x14292967, 0x0a0e6e70),
            X64Word_create(0x27b70a85, 0x46d22ffc), X64Word_create(0x2e1b2138, 0x5c26c926),
            X64Word_create(0x4d2c6dfc, 0x5ac42aed), X64Word_create(0x53380d13, 0x9d95b3df),
            X64Word_create(0x650a7354, 0x8baf63de), X64Word_create(0x766a0abb, 0x3c77b2a8),
            X64Word_create(0x81c2c92e, 0x47edaee6), X64Word_create(0x92722c85, 0x1482353b),
            X64Word_create(0xa2bfe8a1, 0x4cf10364), X64Word_create(0xa81a664b, 0xbc423001),
            X64Word_create(0xc24b8b70, 0xd0f89791), X64Word_create(0xc76c51a3, 0x0654be30),
            X64Word_create(0xd192e819, 0xd6ef5218), X64Word_create(0xd6990624, 0x5565a910),
            X64Word_create(0xf40e3585, 0x5771202a), X64Word_create(0x106aa070, 0x32bbd1b8),
            X64Word_create(0x19a4c116, 0xb8d2d0c8), X64Word_create(0x1e376c08, 0x5141ab53),
            X64Word_create(0x2748774c, 0xdf8eeb99), X64Word_create(0x34b0bcb5, 0xe19b48a8),
            X64Word_create(0x391c0cb3, 0xc5c95a63), X64Word_create(0x4ed8aa4a, 0xe3418acb),
            X64Word_create(0x5b9cca4f, 0x7763e373), X64Word_create(0x682e6ff3, 0xd6b2b8a3),
            X64Word_create(0x748f82ee, 0x5defb2fc), X64Word_create(0x78a5636f, 0x43172f60),
            X64Word_create(0x84c87814, 0xa1f0ab72), X64Word_create(0x8cc70208, 0x1a6439ec),
            X64Word_create(0x90befffa, 0x23631e28), X64Word_create(0xa4506ceb, 0xde82bde9),
            X64Word_create(0xbef9a3f7, 0xb2c67915), X64Word_create(0xc67178f2, 0xe372532b),
            X64Word_create(0xca273ece, 0xea26619c), X64Word_create(0xd186b8c7, 0x21c0c207),
            X64Word_create(0xeada7dd6, 0xcde0eb1e), X64Word_create(0xf57d4f7f, 0xee6ed178),
            X64Word_create(0x06f067aa, 0x72176fba), X64Word_create(0x0a637dc5, 0xa2c898a6),
            X64Word_create(0x113f9804, 0xbef90dae), X64Word_create(0x1b710b35, 0x131c471b),
            X64Word_create(0x28db77f5, 0x23047d84), X64Word_create(0x32caab7b, 0x40c72493),
            X64Word_create(0x3c9ebe0a, 0x15c9bebc), X64Word_create(0x431d67c4, 0x9c100d4c),
            X64Word_create(0x4cc5d4be, 0xcb3e42b6), X64Word_create(0x597f299c, 0xfc657e2a),
            X64Word_create(0x5fcb6fab, 0x3ad6faec), X64Word_create(0x6c44198c, 0x4a475817)
        ];

        // Reusable objects
        var W = [];
        (function () {
            for (var i = 0; i < 80; i++) {
                W[i] = X64Word_create();
            }
        }());

        /**
         * SHA-512 hash algorithm.
         */
        var SHA512 = C_algo.SHA512 = Hasher.extend({
            _doReset: function () {
                this._hash = new X64WordArray.init([
                    new X64Word.init(0x6a09e667, 0xf3bcc908), new X64Word.init(0xbb67ae85, 0x84caa73b),
                    new X64Word.init(0x3c6ef372, 0xfe94f82b), new X64Word.init(0xa54ff53a, 0x5f1d36f1),
                    new X64Word.init(0x510e527f, 0xade682d1), new X64Word.init(0x9b05688c, 0x2b3e6c1f),
                    new X64Word.init(0x1f83d9ab, 0xfb41bd6b), new X64Word.init(0x5be0cd19, 0x137e2179)
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Shortcuts
                var H = this._hash.words;

                var H0 = H[0];
                var H1 = H[1];
                var H2 = H[2];
                var H3 = H[3];
                var H4 = H[4];
                var H5 = H[5];
                var H6 = H[6];
                var H7 = H[7];

                var H0h = H0.high;
                var H0l = H0.low;
                var H1h = H1.high;
                var H1l = H1.low;
                var H2h = H2.high;
                var H2l = H2.low;
                var H3h = H3.high;
                var H3l = H3.low;
                var H4h = H4.high;
                var H4l = H4.low;
                var H5h = H5.high;
                var H5l = H5.low;
                var H6h = H6.high;
                var H6l = H6.low;
                var H7h = H7.high;
                var H7l = H7.low;

                // Working variables
                var ah = H0h;
                var al = H0l;
                var bh = H1h;
                var bl = H1l;
                var ch = H2h;
                var cl = H2l;
                var dh = H3h;
                var dl = H3l;
                var eh = H4h;
                var el = H4l;
                var fh = H5h;
                var fl = H5l;
                var gh = H6h;
                var gl = H6l;
                var hh = H7h;
                var hl = H7l;

                // Rounds
                for (var i = 0; i < 80; i++) {
                    // Shortcut
                    var Wi = W[i];

                    // Extend message
                    if (i < 16) {
                        var Wih = Wi.high = M[offset + i * 2]     | 0;
                        var Wil = Wi.low  = M[offset + i * 2 + 1] | 0;
                    } else {
                        // Gamma0
                        var gamma0x  = W[i - 15];
                        var gamma0xh = gamma0x.high;
                        var gamma0xl = gamma0x.low;
                        var gamma0h  = ((gamma0xh >>> 1) | (gamma0xl << 31)) ^ ((gamma0xh >>> 8) | (gamma0xl << 24)) ^ (gamma0xh >>> 7);
                        var gamma0l  = ((gamma0xl >>> 1) | (gamma0xh << 31)) ^ ((gamma0xl >>> 8) | (gamma0xh << 24)) ^ ((gamma0xl >>> 7) | (gamma0xh << 25));

                        // Gamma1
                        var gamma1x  = W[i - 2];
                        var gamma1xh = gamma1x.high;
                        var gamma1xl = gamma1x.low;
                        var gamma1h  = ((gamma1xh >>> 19) | (gamma1xl << 13)) ^ ((gamma1xh << 3) | (gamma1xl >>> 29)) ^ (gamma1xh >>> 6);
                        var gamma1l  = ((gamma1xl >>> 19) | (gamma1xh << 13)) ^ ((gamma1xl << 3) | (gamma1xh >>> 29)) ^ ((gamma1xl >>> 6) | (gamma1xh << 26));

                        // W[i] = gamma0 + W[i - 7] + gamma1 + W[i - 16]
                        var Wi7  = W[i - 7];
                        var Wi7h = Wi7.high;
                        var Wi7l = Wi7.low;

                        var Wi16  = W[i - 16];
                        var Wi16h = Wi16.high;
                        var Wi16l = Wi16.low;

                        var Wil = gamma0l + Wi7l;
                        var Wih = gamma0h + Wi7h + ((Wil >>> 0) < (gamma0l >>> 0) ? 1 : 0);
                        var Wil = Wil + gamma1l;
                        var Wih = Wih + gamma1h + ((Wil >>> 0) < (gamma1l >>> 0) ? 1 : 0);
                        var Wil = Wil + Wi16l;
                        var Wih = Wih + Wi16h + ((Wil >>> 0) < (Wi16l >>> 0) ? 1 : 0);

                        Wi.high = Wih;
                        Wi.low  = Wil;
                    }

                    var chh  = (eh & fh) ^ (~eh & gh);
                    var chl  = (el & fl) ^ (~el & gl);
                    var majh = (ah & bh) ^ (ah & ch) ^ (bh & ch);
                    var majl = (al & bl) ^ (al & cl) ^ (bl & cl);

                    var sigma0h = ((ah >>> 28) | (al << 4))  ^ ((ah << 30)  | (al >>> 2)) ^ ((ah << 25) | (al >>> 7));
                    var sigma0l = ((al >>> 28) | (ah << 4))  ^ ((al << 30)  | (ah >>> 2)) ^ ((al << 25) | (ah >>> 7));
                    var sigma1h = ((eh >>> 14) | (el << 18)) ^ ((eh >>> 18) | (el << 14)) ^ ((eh << 23) | (el >>> 9));
                    var sigma1l = ((el >>> 14) | (eh << 18)) ^ ((el >>> 18) | (eh << 14)) ^ ((el << 23) | (eh >>> 9));

                    // t1 = h + sigma1 + ch + K[i] + W[i]
                    var Ki  = K[i];
                    var Kih = Ki.high;
                    var Kil = Ki.low;

                    var t1l = hl + sigma1l;
                    var t1h = hh + sigma1h + ((t1l >>> 0) < (hl >>> 0) ? 1 : 0);
                    var t1l = t1l + chl;
                    var t1h = t1h + chh + ((t1l >>> 0) < (chl >>> 0) ? 1 : 0);
                    var t1l = t1l + Kil;
                    var t1h = t1h + Kih + ((t1l >>> 0) < (Kil >>> 0) ? 1 : 0);
                    var t1l = t1l + Wil;
                    var t1h = t1h + Wih + ((t1l >>> 0) < (Wil >>> 0) ? 1 : 0);

                    // t2 = sigma0 + maj
                    var t2l = sigma0l + majl;
                    var t2h = sigma0h + majh + ((t2l >>> 0) < (sigma0l >>> 0) ? 1 : 0);

                    // Update working variables
                    hh = gh;
                    hl = gl;
                    gh = fh;
                    gl = fl;
                    fh = eh;
                    fl = el;
                    el = (dl + t1l) | 0;
                    eh = (dh + t1h + ((el >>> 0) < (dl >>> 0) ? 1 : 0)) | 0;
                    dh = ch;
                    dl = cl;
                    ch = bh;
                    cl = bl;
                    bh = ah;
                    bl = al;
                    al = (t1l + t2l) | 0;
                    ah = (t1h + t2h + ((al >>> 0) < (t1l >>> 0) ? 1 : 0)) | 0;
                }

                // Intermediate hash value
                H0l = H0.low  = (H0l + al);
                H0.high = (H0h + ah + ((H0l >>> 0) < (al >>> 0) ? 1 : 0));
                H1l = H1.low  = (H1l + bl);
                H1.high = (H1h + bh + ((H1l >>> 0) < (bl >>> 0) ? 1 : 0));
                H2l = H2.low  = (H2l + cl);
                H2.high = (H2h + ch + ((H2l >>> 0) < (cl >>> 0) ? 1 : 0));
                H3l = H3.low  = (H3l + dl);
                H3.high = (H3h + dh + ((H3l >>> 0) < (dl >>> 0) ? 1 : 0));
                H4l = H4.low  = (H4l + el);
                H4.high = (H4h + eh + ((H4l >>> 0) < (el >>> 0) ? 1 : 0));
                H5l = H5.low  = (H5l + fl);
                H5.high = (H5h + fh + ((H5l >>> 0) < (fl >>> 0) ? 1 : 0));
                H6l = H6.low  = (H6l + gl);
                H6.high = (H6h + gh + ((H6l >>> 0) < (gl >>> 0) ? 1 : 0));
                H7l = H7.low  = (H7l + hl);
                H7.high = (H7h + hh + ((H7l >>> 0) < (hl >>> 0) ? 1 : 0));
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 128) >>> 10) << 5) + 30] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 128) >>> 10) << 5) + 31] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Convert hash to 32-bit word array before returning
                var hash = this._hash.toX32();

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            },

            blockSize: 1024/32
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA512('message');
         *     var hash = CryptoJS.SHA512(wordArray);
         */
        C.SHA512 = Hasher._createHelper(SHA512);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA512(message, key);
         */
        C.HmacSHA512 = Hasher._createHmacHelper(SHA512);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var X64WordArray = C_x64.WordArray;
        var C_algo = C.algo;
        var SHA512 = C_algo.SHA512;

        /**
         * SHA-384 hash algorithm.
         */
        var SHA384 = C_algo.SHA384 = SHA512.extend({
            _doReset: function () {
                this._hash = new X64WordArray.init([
                    new X64Word.init(0xcbbb9d5d, 0xc1059ed8), new X64Word.init(0x629a292a, 0x367cd507),
                    new X64Word.init(0x9159015a, 0x3070dd17), new X64Word.init(0x152fecd8, 0xf70e5939),
                    new X64Word.init(0x67332667, 0xffc00b31), new X64Word.init(0x8eb44a87, 0x68581511),
                    new X64Word.init(0xdb0c2e0d, 0x64f98fa7), new X64Word.init(0x47b5481d, 0xbefa4fa4)
                ]);
            },

            _doFinalize: function () {
                var hash = SHA512._doFinalize.call(this);

                hash.sigBytes -= 16;

                return hash;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA384('message');
         *     var hash = CryptoJS.SHA384(wordArray);
         */
        C.SHA384 = SHA512._createHelper(SHA384);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA384(message, key);
         */
        C.HmacSHA384 = SHA512._createHmacHelper(SHA384);
    }());


    /**
     * Cipher core components.
     */
    CryptoJS.lib.Cipher || (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var BufferedBlockAlgorithm = C_lib.BufferedBlockAlgorithm;
        var C_enc = C.enc;
        var Utf8 = C_enc.Utf8;
        var Base64 = C_enc.Base64;
        var C_algo = C.algo;
        var EvpKDF = C_algo.EvpKDF;

        /**
         * Abstract base cipher template.
         *
         * @property {number} keySize This cipher's key size. Default: 4 (128 bits)
         * @property {number} ivSize This cipher's IV size. Default: 4 (128 bits)
         * @property {number} _ENC_XFORM_MODE A constant representing encryption mode.
         * @property {number} _DEC_XFORM_MODE A constant representing decryption mode.
         */
        var Cipher = C_lib.Cipher = BufferedBlockAlgorithm.extend({
            /**
             * Configuration options.
             *
             * @property {WordArray} iv The IV to use for this operation.
             */
            cfg: Base.extend(),

            /**
             * Creates this cipher in encryption mode.
             *
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {Cipher} A cipher instance.
             *
             * @static
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.createEncryptor(keyWordArray, { iv: ivWordArray });
             */
            createEncryptor: function (key, cfg) {
                return this.create(this._ENC_XFORM_MODE, key, cfg);
            },

            /**
             * Creates this cipher in decryption mode.
             *
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {Cipher} A cipher instance.
             *
             * @static
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.createDecryptor(keyWordArray, { iv: ivWordArray });
             */
            createDecryptor: function (key, cfg) {
                return this.create(this._DEC_XFORM_MODE, key, cfg);
            },

            /**
             * Initializes a newly created cipher.
             *
             * @param {number} xformMode Either the encryption or decryption transormation mode constant.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.create(CryptoJS.algo.AES._ENC_XFORM_MODE, keyWordArray, { iv: ivWordArray });
             */
            init: function (xformMode, key, cfg) {
                // Apply config defaults
                this.cfg = this.cfg.extend(cfg);

                // Store transform mode and key
                this._xformMode = xformMode;
                this._key = key;

                // Set initial values
                this.reset();
            },

            /**
             * Resets this cipher to its initial state.
             *
             * @example
             *
             *     cipher.reset();
             */
            reset: function () {
                // Reset data buffer
                BufferedBlockAlgorithm.reset.call(this);

                // Perform concrete-cipher logic
                this._doReset();
            },

            /**
             * Adds data to be encrypted or decrypted.
             *
             * @param {WordArray|string} dataUpdate The data to encrypt or decrypt.
             *
             * @return {WordArray} The data after processing.
             *
             * @example
             *
             *     var encrypted = cipher.process('data');
             *     var encrypted = cipher.process(wordArray);
             */
            process: function (dataUpdate) {
                // Append
                this._append(dataUpdate);

                // Process available blocks
                return this._process();
            },

            /**
             * Finalizes the encryption or decryption process.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} dataUpdate The final data to encrypt or decrypt.
             *
             * @return {WordArray} The data after final processing.
             *
             * @example
             *
             *     var encrypted = cipher.finalize();
             *     var encrypted = cipher.finalize('data');
             *     var encrypted = cipher.finalize(wordArray);
             */
            finalize: function (dataUpdate) {
                // Final data update
                if (dataUpdate) {
                    this._append(dataUpdate);
                }

                // Perform concrete-cipher logic
                var finalProcessedData = this._doFinalize();

                return finalProcessedData;
            },

            keySize: 128/32,

            ivSize: 128/32,

            _ENC_XFORM_MODE: 1,

            _DEC_XFORM_MODE: 2,

            /**
             * Creates shortcut functions to a cipher's object interface.
             *
             * @param {Cipher} cipher The cipher to create a helper for.
             *
             * @return {Object} An object with encrypt and decrypt shortcut functions.
             *
             * @static
             *
             * @example
             *
             *     var AES = CryptoJS.lib.Cipher._createHelper(CryptoJS.algo.AES);
             */
            _createHelper: (function () {
                function selectCipherStrategy(key) {
                    if (typeof key == 'string') {
                        return PasswordBasedCipher;
                    } else {
                        return SerializableCipher;
                    }
                }

                return function (cipher) {
                    return {
                        encrypt: function (message, key, cfg) {
                            return selectCipherStrategy(key).encrypt(cipher, message, key, cfg);
                        },

                        decrypt: function (ciphertext, key, cfg) {
                            return selectCipherStrategy(key).decrypt(cipher, ciphertext, key, cfg);
                        }
                    };
                };
            }())
        });

        /**
         * Abstract base stream cipher template.
         *
         * @property {number} blockSize The number of 32-bit words this cipher operates on. Default: 1 (32 bits)
         */
        var StreamCipher = C_lib.StreamCipher = Cipher.extend({
            _doFinalize: function () {
                // Process partial blocks
                var finalProcessedBlocks = this._process(!!'flush');

                return finalProcessedBlocks;
            },

            blockSize: 1
        });

        /**
         * Mode namespace.
         */
        var C_mode = C.mode = {};

        /**
         * Abstract base block cipher mode template.
         */
        var BlockCipherMode = C_lib.BlockCipherMode = Base.extend({
            /**
             * Creates this mode for encryption.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @static
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.createEncryptor(cipher, iv.words);
             */
            createEncryptor: function (cipher, iv) {
                return this.Encryptor.create(cipher, iv);
            },

            /**
             * Creates this mode for decryption.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @static
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.createDecryptor(cipher, iv.words);
             */
            createDecryptor: function (cipher, iv) {
                return this.Decryptor.create(cipher, iv);
            },

            /**
             * Initializes a newly created mode.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.Encryptor.create(cipher, iv.words);
             */
            init: function (cipher, iv) {
                this._cipher = cipher;
                this._iv = iv;
            }
        });

        /**
         * Cipher Block Chaining mode.
         */
        var CBC = C_mode.CBC = (function () {
            /**
             * Abstract base CBC mode.
             */
            var CBC = BlockCipherMode.extend();

            /**
             * CBC encryptor.
             */
            CBC.Encryptor = CBC.extend({
                /**
                 * Processes the data block at offset.
                 *
                 * @param {Array} words The data words to operate on.
                 * @param {number} offset The offset where the block starts.
                 *
                 * @example
                 *
                 *     mode.processBlock(data.words, offset);
                 */
                processBlock: function (words, offset) {
                    // Shortcuts
                    var cipher = this._cipher;
                    var blockSize = cipher.blockSize;

                    // XOR and encrypt
                    xorBlock.call(this, words, offset, blockSize);
                    cipher.encryptBlock(words, offset);

                    // Remember this block to use with next block
                    this._prevBlock = words.slice(offset, offset + blockSize);
                }
            });

            /**
             * CBC decryptor.
             */
            CBC.Decryptor = CBC.extend({
                /**
                 * Processes the data block at offset.
                 *
                 * @param {Array} words The data words to operate on.
                 * @param {number} offset The offset where the block starts.
                 *
                 * @example
                 *
                 *     mode.processBlock(data.words, offset);
                 */
                processBlock: function (words, offset) {
                    // Shortcuts
                    var cipher = this._cipher;
                    var blockSize = cipher.blockSize;

                    // Remember this block to use with next block
                    var thisBlock = words.slice(offset, offset + blockSize);

                    // Decrypt and XOR
                    cipher.decryptBlock(words, offset);
                    xorBlock.call(this, words, offset, blockSize);

                    // This block becomes the previous block
                    this._prevBlock = thisBlock;
                }
            });

            function xorBlock(words, offset, blockSize) {
                // Shortcut
                var iv = this._iv;

                // Choose mixing block
                if (iv) {
                    var block = iv;

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                } else {
                    var block = this._prevBlock;
                }

                // XOR blocks
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= block[i];
                }
            }

            return CBC;
        }());

        /**
         * Padding namespace.
         */
        var C_pad = C.pad = {};

        /**
         * PKCS #5/7 padding strategy.
         */
        var Pkcs7 = C_pad.Pkcs7 = {
            /**
             * Pads data using the algorithm defined in PKCS #5/7.
             *
             * @param {WordArray} data The data to pad.
             * @param {number} blockSize The multiple that the data should be padded to.
             *
             * @static
             *
             * @example
             *
             *     CryptoJS.pad.Pkcs7.pad(wordArray, 4);
             */
            pad: function (data, blockSize) {
                // Shortcut
                var blockSizeBytes = blockSize * 4;

                // Count padding bytes
                var nPaddingBytes = blockSizeBytes - data.sigBytes % blockSizeBytes;

                // Create padding word
                var paddingWord = (nPaddingBytes << 24) | (nPaddingBytes << 16) | (nPaddingBytes << 8) | nPaddingBytes;

                // Create padding
                var paddingWords = [];
                for (var i = 0; i < nPaddingBytes; i += 4) {
                    paddingWords.push(paddingWord);
                }
                var padding = WordArray.create(paddingWords, nPaddingBytes);

                // Add padding
                data.concat(padding);
            },

            /**
             * Unpads data that had been padded using the algorithm defined in PKCS #5/7.
             *
             * @param {WordArray} data The data to unpad.
             *
             * @static
             *
             * @example
             *
             *     CryptoJS.pad.Pkcs7.unpad(wordArray);
             */
            unpad: function (data) {
                // Get number of padding bytes from last byte
                var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

                // Remove padding
                data.sigBytes -= nPaddingBytes;
            }
        };

        /**
         * Abstract base block cipher template.
         *
         * @property {number} blockSize The number of 32-bit words this cipher operates on. Default: 4 (128 bits)
         */
        var BlockCipher = C_lib.BlockCipher = Cipher.extend({
            /**
             * Configuration options.
             *
             * @property {Mode} mode The block mode to use. Default: CBC
             * @property {Padding} padding The padding strategy to use. Default: Pkcs7
             */
            cfg: Cipher.cfg.extend({
                mode: CBC,
                padding: Pkcs7
            }),

            reset: function () {
                // Reset cipher
                Cipher.reset.call(this);

                // Shortcuts
                var cfg = this.cfg;
                var iv = cfg.iv;
                var mode = cfg.mode;

                // Reset block mode
                if (this._xformMode == this._ENC_XFORM_MODE) {
                    var modeCreator = mode.createEncryptor;
                } else /* if (this._xformMode == this._DEC_XFORM_MODE) */ {
                    var modeCreator = mode.createDecryptor;
                    // Keep at least one block in the buffer for unpadding
                    this._minBufferSize = 1;
                }

                if (this._mode && this._mode.__creator == modeCreator) {
                    this._mode.init(this, iv && iv.words);
                } else {
                    this._mode = modeCreator.call(mode, this, iv && iv.words);
                    this._mode.__creator = modeCreator;
                }
            },

            _doProcessBlock: function (words, offset) {
                this._mode.processBlock(words, offset);
            },

            _doFinalize: function () {
                // Shortcut
                var padding = this.cfg.padding;

                // Finalize
                if (this._xformMode == this._ENC_XFORM_MODE) {
                    // Pad data
                    padding.pad(this._data, this.blockSize);

                    // Process final blocks
                    var finalProcessedBlocks = this._process(!!'flush');
                } else /* if (this._xformMode == this._DEC_XFORM_MODE) */ {
                    // Process final blocks
                    var finalProcessedBlocks = this._process(!!'flush');

                    // Unpad data
                    padding.unpad(finalProcessedBlocks);
                }

                return finalProcessedBlocks;
            },

            blockSize: 128/32
        });

        /**
         * A collection of cipher parameters.
         *
         * @property {WordArray} ciphertext The raw ciphertext.
         * @property {WordArray} key The key to this ciphertext.
         * @property {WordArray} iv The IV used in the ciphering operation.
         * @property {WordArray} salt The salt used with a key derivation function.
         * @property {Cipher} algorithm The cipher algorithm.
         * @property {Mode} mode The block mode used in the ciphering operation.
         * @property {Padding} padding The padding scheme used in the ciphering operation.
         * @property {number} blockSize The block size of the cipher.
         * @property {Format} formatter The default formatting strategy to convert this cipher params object to a string.
         */
        var CipherParams = C_lib.CipherParams = Base.extend({
            /**
             * Initializes a newly created cipher params object.
             *
             * @param {Object} cipherParams An object with any of the possible cipher parameters.
             *
             * @example
             *
             *     var cipherParams = CryptoJS.lib.CipherParams.create({
	         *         ciphertext: ciphertextWordArray,
	         *         key: keyWordArray,
	         *         iv: ivWordArray,
	         *         salt: saltWordArray,
	         *         algorithm: CryptoJS.algo.AES,
	         *         mode: CryptoJS.mode.CBC,
	         *         padding: CryptoJS.pad.PKCS7,
	         *         blockSize: 4,
	         *         formatter: CryptoJS.format.OpenSSL
	         *     });
             */
            init: function (cipherParams) {
                this.mixIn(cipherParams);
            },

            /**
             * Converts this cipher params object to a string.
             *
             * @param {Format} formatter (Optional) The formatting strategy to use.
             *
             * @return {string} The stringified cipher params.
             *
             * @throws Error If neither the formatter nor the default formatter is set.
             *
             * @example
             *
             *     var string = cipherParams + '';
             *     var string = cipherParams.toString();
             *     var string = cipherParams.toString(CryptoJS.format.OpenSSL);
             */
            toString: function (formatter) {
                return (formatter || this.formatter).stringify(this);
            }
        });

        /**
         * Format namespace.
         */
        var C_format = C.format = {};

        /**
         * OpenSSL formatting strategy.
         */
        var OpenSSLFormatter = C_format.OpenSSL = {
            /**
             * Converts a cipher params object to an OpenSSL-compatible string.
             *
             * @param {CipherParams} cipherParams The cipher params object.
             *
             * @return {string} The OpenSSL-compatible string.
             *
             * @static
             *
             * @example
             *
             *     var openSSLString = CryptoJS.format.OpenSSL.stringify(cipherParams);
             */
            stringify: function (cipherParams) {
                // Shortcuts
                var ciphertext = cipherParams.ciphertext;
                var salt = cipherParams.salt;

                // Format
                if (salt) {
                    var wordArray = WordArray.create([0x53616c74, 0x65645f5f]).concat(salt).concat(ciphertext);
                } else {
                    var wordArray = ciphertext;
                }

                return wordArray.toString(Base64);
            },

            /**
             * Converts an OpenSSL-compatible string to a cipher params object.
             *
             * @param {string} openSSLStr The OpenSSL-compatible string.
             *
             * @return {CipherParams} The cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var cipherParams = CryptoJS.format.OpenSSL.parse(openSSLString);
             */
            parse: function (openSSLStr) {
                // Parse base64
                var ciphertext = Base64.parse(openSSLStr);

                // Shortcut
                var ciphertextWords = ciphertext.words;

                // Test for salt
                if (ciphertextWords[0] == 0x53616c74 && ciphertextWords[1] == 0x65645f5f) {
                    // Extract salt
                    var salt = WordArray.create(ciphertextWords.slice(2, 4));

                    // Remove salt from ciphertext
                    ciphertextWords.splice(0, 4);
                    ciphertext.sigBytes -= 16;
                }

                return CipherParams.create({ ciphertext: ciphertext, salt: salt });
            }
        };

        /**
         * A cipher wrapper that returns ciphertext as a serializable cipher params object.
         */
        var SerializableCipher = C_lib.SerializableCipher = Base.extend({
            /**
             * Configuration options.
             *
             * @property {Formatter} format The formatting strategy to convert cipher param objects to and from a string. Default: OpenSSL
             */
            cfg: Base.extend({
                format: OpenSSLFormatter
            }),

            /**
             * Encrypts a message.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {WordArray|string} message The message to encrypt.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {CipherParams} A cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key);
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key, { iv: iv });
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             */
            encrypt: function (cipher, message, key, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Encrypt
                var encryptor = cipher.createEncryptor(key, cfg);
                var ciphertext = encryptor.finalize(message);

                // Shortcut
                var cipherCfg = encryptor.cfg;

                // Create and return serializable cipher params
                return CipherParams.create({
                    ciphertext: ciphertext,
                    key: key,
                    iv: cipherCfg.iv,
                    algorithm: cipher,
                    mode: cipherCfg.mode,
                    padding: cipherCfg.padding,
                    blockSize: cipher.blockSize,
                    formatter: cfg.format
                });
            },

            /**
             * Decrypts serialized ciphertext.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {CipherParams|string} ciphertext The ciphertext to decrypt.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {WordArray} The plaintext.
             *
             * @static
             *
             * @example
             *
             *     var plaintext = CryptoJS.lib.SerializableCipher.decrypt(CryptoJS.algo.AES, formattedCiphertext, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             *     var plaintext = CryptoJS.lib.SerializableCipher.decrypt(CryptoJS.algo.AES, ciphertextParams, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             */
            decrypt: function (cipher, ciphertext, key, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Convert string to CipherParams
                ciphertext = this._parse(ciphertext, cfg.format);

                // Decrypt
                var plaintext = cipher.createDecryptor(key, cfg).finalize(ciphertext.ciphertext);

                return plaintext;
            },

            /**
             * Converts serialized ciphertext to CipherParams,
             * else assumed CipherParams already and returns ciphertext unchanged.
             *
             * @param {CipherParams|string} ciphertext The ciphertext.
             * @param {Formatter} format The formatting strategy to use to parse serialized ciphertext.
             *
             * @return {CipherParams} The unserialized ciphertext.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher._parse(ciphertextStringOrParams, format);
             */
            _parse: function (ciphertext, format) {
                if (typeof ciphertext == 'string') {
                    return format.parse(ciphertext, this);
                } else {
                    return ciphertext;
                }
            }
        });

        /**
         * Key derivation function namespace.
         */
        var C_kdf = C.kdf = {};

        /**
         * OpenSSL key derivation function.
         */
        var OpenSSLKdf = C_kdf.OpenSSL = {
            /**
             * Derives a key and IV from a password.
             *
             * @param {string} password The password to derive from.
             * @param {number} keySize The size in words of the key to generate.
             * @param {number} ivSize The size in words of the IV to generate.
             * @param {WordArray|string} salt (Optional) A 64-bit salt to use. If omitted, a salt will be generated randomly.
             *
             * @return {CipherParams} A cipher params object with the key, IV, and salt.
             *
             * @static
             *
             * @example
             *
             *     var derivedParams = CryptoJS.kdf.OpenSSL.execute('Password', 256/32, 128/32);
             *     var derivedParams = CryptoJS.kdf.OpenSSL.execute('Password', 256/32, 128/32, 'saltsalt');
             */
            execute: function (password, keySize, ivSize, salt) {
                // Generate random salt
                if (!salt) {
                    salt = WordArray.random(64/8);
                }

                // Derive key and IV
                var key = EvpKDF.create({ keySize: keySize + ivSize }).compute(password, salt);

                // Separate key and IV
                var iv = WordArray.create(key.words.slice(keySize), ivSize * 4);
                key.sigBytes = keySize * 4;

                // Return params
                return CipherParams.create({ key: key, iv: iv, salt: salt });
            }
        };

        /**
         * A serializable cipher wrapper that derives the key from a password,
         * and returns ciphertext as a serializable cipher params object.
         */
        var PasswordBasedCipher = C_lib.PasswordBasedCipher = SerializableCipher.extend({
            /**
             * Configuration options.
             *
             * @property {KDF} kdf The key derivation function to use to generate a key and IV from a password. Default: OpenSSL
             */
            cfg: SerializableCipher.cfg.extend({
                kdf: OpenSSLKdf
            }),

            /**
             * Encrypts a message using a password.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {WordArray|string} message The message to encrypt.
             * @param {string} password The password.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {CipherParams} A cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.PasswordBasedCipher.encrypt(CryptoJS.algo.AES, message, 'password');
             *     var ciphertextParams = CryptoJS.lib.PasswordBasedCipher.encrypt(CryptoJS.algo.AES, message, 'password', { format: CryptoJS.format.OpenSSL });
             */
            encrypt: function (cipher, message, password, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Derive key and other params
                var derivedParams = cfg.kdf.execute(password, cipher.keySize, cipher.ivSize);

                // Add IV to config
                cfg.iv = derivedParams.iv;

                // Encrypt
                var ciphertext = SerializableCipher.encrypt.call(this, cipher, message, derivedParams.key, cfg);

                // Mix in derived params
                ciphertext.mixIn(derivedParams);

                return ciphertext;
            },

            /**
             * Decrypts serialized ciphertext using a password.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {CipherParams|string} ciphertext The ciphertext to decrypt.
             * @param {string} password The password.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {WordArray} The plaintext.
             *
             * @static
             *
             * @example
             *
             *     var plaintext = CryptoJS.lib.PasswordBasedCipher.decrypt(CryptoJS.algo.AES, formattedCiphertext, 'password', { format: CryptoJS.format.OpenSSL });
             *     var plaintext = CryptoJS.lib.PasswordBasedCipher.decrypt(CryptoJS.algo.AES, ciphertextParams, 'password', { format: CryptoJS.format.OpenSSL });
             */
            decrypt: function (cipher, ciphertext, password, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Convert string to CipherParams
                ciphertext = this._parse(ciphertext, cfg.format);

                // Derive key and other params
                var derivedParams = cfg.kdf.execute(password, cipher.keySize, cipher.ivSize, ciphertext.salt);

                // Add IV to config
                cfg.iv = derivedParams.iv;

                // Decrypt
                var plaintext = SerializableCipher.decrypt.call(this, cipher, ciphertext, derivedParams.key, cfg);

                return plaintext;
            }
        });
    }());


    /**
     * Cipher Feedback block mode.
     */
    CryptoJS.mode.CFB = (function () {
        var CFB = CryptoJS.lib.BlockCipherMode.extend();

        CFB.Encryptor = CFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher;
                var blockSize = cipher.blockSize;

                generateKeystreamAndEncrypt.call(this, words, offset, blockSize, cipher);

                // Remember this block to use with next block
                this._prevBlock = words.slice(offset, offset + blockSize);
            }
        });

        CFB.Decryptor = CFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher;
                var blockSize = cipher.blockSize;

                // Remember this block to use with next block
                var thisBlock = words.slice(offset, offset + blockSize);

                generateKeystreamAndEncrypt.call(this, words, offset, blockSize, cipher);

                // This block becomes the previous block
                this._prevBlock = thisBlock;
            }
        });

        function generateKeystreamAndEncrypt(words, offset, blockSize, cipher) {
            // Shortcut
            var iv = this._iv;

            // Generate keystream
            if (iv) {
                var keystream = iv.slice(0);

                // Remove IV for subsequent blocks
                this._iv = undefined;
            } else {
                var keystream = this._prevBlock;
            }
            cipher.encryptBlock(keystream, 0);

            // Encrypt
            for (var i = 0; i < blockSize; i++) {
                words[offset + i] ^= keystream[i];
            }
        }

        return CFB;
    }());


    /**
     * Electronic Codebook block mode.
     */
    CryptoJS.mode.ECB = (function () {
        var ECB = CryptoJS.lib.BlockCipherMode.extend();

        ECB.Encryptor = ECB.extend({
            processBlock: function (words, offset) {
                this._cipher.encryptBlock(words, offset);
            }
        });

        ECB.Decryptor = ECB.extend({
            processBlock: function (words, offset) {
                this._cipher.decryptBlock(words, offset);
            }
        });

        return ECB;
    }());


    /**
     * ANSI X.923 padding strategy.
     */
    CryptoJS.pad.AnsiX923 = {
        pad: function (data, blockSize) {
            // Shortcuts
            var dataSigBytes = data.sigBytes;
            var blockSizeBytes = blockSize * 4;

            // Count padding bytes
            var nPaddingBytes = blockSizeBytes - dataSigBytes % blockSizeBytes;

            // Compute last byte position
            var lastBytePos = dataSigBytes + nPaddingBytes - 1;

            // Pad
            data.clamp();
            data.words[lastBytePos >>> 2] |= nPaddingBytes << (24 - (lastBytePos % 4) * 8);
            data.sigBytes += nPaddingBytes;
        },

        unpad: function (data) {
            // Get number of padding bytes from last byte
            var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

            // Remove padding
            data.sigBytes -= nPaddingBytes;
        }
    };


    /**
     * ISO 10126 padding strategy.
     */
    CryptoJS.pad.Iso10126 = {
        pad: function (data, blockSize) {
            // Shortcut
            var blockSizeBytes = blockSize * 4;

            // Count padding bytes
            var nPaddingBytes = blockSizeBytes - data.sigBytes % blockSizeBytes;

            // Pad
            data.concat(CryptoJS.lib.WordArray.random(nPaddingBytes - 1)).
            concat(CryptoJS.lib.WordArray.create([nPaddingBytes << 24], 1));
        },

        unpad: function (data) {
            // Get number of padding bytes from last byte
            var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

            // Remove padding
            data.sigBytes -= nPaddingBytes;
        }
    };


    /**
     * ISO/IEC 9797-1 Padding Method 2.
     */
    CryptoJS.pad.Iso97971 = {
        pad: function (data, blockSize) {
            // Add 0x80 byte
            data.concat(CryptoJS.lib.WordArray.create([0x80000000], 1));

            // Zero pad the rest
            CryptoJS.pad.ZeroPadding.pad(data, blockSize);
        },

        unpad: function (data) {
            // Remove zero padding
            CryptoJS.pad.ZeroPadding.unpad(data);

            // Remove one more byte -- the 0x80 byte
            data.sigBytes--;
        }
    };


    /**
     * Output Feedback block mode.
     */
    CryptoJS.mode.OFB = (function () {
        var OFB = CryptoJS.lib.BlockCipherMode.extend();

        var Encryptor = OFB.Encryptor = OFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var keystream = this._keystream;

                // Generate keystream
                if (iv) {
                    keystream = this._keystream = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }
                cipher.encryptBlock(keystream, 0);

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        OFB.Decryptor = Encryptor;

        return OFB;
    }());


    /**
     * A noop padding strategy.
     */
    CryptoJS.pad.NoPadding = {
        pad: function () {
        },

        unpad: function () {
        }
    };


    (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var CipherParams = C_lib.CipherParams;
        var C_enc = C.enc;
        var Hex = C_enc.Hex;
        var C_format = C.format;

        var HexFormatter = C_format.Hex = {
            /**
             * Converts the ciphertext of a cipher params object to a hexadecimally encoded string.
             *
             * @param {CipherParams} cipherParams The cipher params object.
             *
             * @return {string} The hexadecimally encoded string.
             *
             * @static
             *
             * @example
             *
             *     var hexString = CryptoJS.format.Hex.stringify(cipherParams);
             */
            stringify: function (cipherParams) {
                return cipherParams.ciphertext.toString(Hex);
            },

            /**
             * Converts a hexadecimally encoded ciphertext string to a cipher params object.
             *
             * @param {string} input The hexadecimally encoded string.
             *
             * @return {CipherParams} The cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var cipherParams = CryptoJS.format.Hex.parse(hexString);
             */
            parse: function (input) {
                var ciphertext = Hex.parse(input);
                return CipherParams.create({ ciphertext: ciphertext });
            }
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var BlockCipher = C_lib.BlockCipher;
        var C_algo = C.algo;

        // Lookup tables
        var SBOX = [];
        var INV_SBOX = [];
        var SUB_MIX_0 = [];
        var SUB_MIX_1 = [];
        var SUB_MIX_2 = [];
        var SUB_MIX_3 = [];
        var INV_SUB_MIX_0 = [];
        var INV_SUB_MIX_1 = [];
        var INV_SUB_MIX_2 = [];
        var INV_SUB_MIX_3 = [];

        // Compute lookup tables
        (function () {
            // Compute double table
            var d = [];
            for (var i = 0; i < 256; i++) {
                if (i < 128) {
                    d[i] = i << 1;
                } else {
                    d[i] = (i << 1) ^ 0x11b;
                }
            }

            // Walk GF(2^8)
            var x = 0;
            var xi = 0;
            for (var i = 0; i < 256; i++) {
                // Compute sbox
                var sx = xi ^ (xi << 1) ^ (xi << 2) ^ (xi << 3) ^ (xi << 4);
                sx = (sx >>> 8) ^ (sx & 0xff) ^ 0x63;
                SBOX[x] = sx;
                INV_SBOX[sx] = x;

                // Compute multiplication
                var x2 = d[x];
                var x4 = d[x2];
                var x8 = d[x4];

                // Compute sub bytes, mix columns tables
                var t = (d[sx] * 0x101) ^ (sx * 0x1010100);
                SUB_MIX_0[x] = (t << 24) | (t >>> 8);
                SUB_MIX_1[x] = (t << 16) | (t >>> 16);
                SUB_MIX_2[x] = (t << 8)  | (t >>> 24);
                SUB_MIX_3[x] = t;

                // Compute inv sub bytes, inv mix columns tables
                var t = (x8 * 0x1010101) ^ (x4 * 0x10001) ^ (x2 * 0x101) ^ (x * 0x1010100);
                INV_SUB_MIX_0[sx] = (t << 24) | (t >>> 8);
                INV_SUB_MIX_1[sx] = (t << 16) | (t >>> 16);
                INV_SUB_MIX_2[sx] = (t << 8)  | (t >>> 24);
                INV_SUB_MIX_3[sx] = t;

                // Compute next counter
                if (!x) {
                    x = xi = 1;
                } else {
                    x = x2 ^ d[d[d[x8 ^ x2]]];
                    xi ^= d[d[xi]];
                }
            }
        }());

        // Precomputed Rcon lookup
        var RCON = [0x00, 0x01, 0x02, 0x04, 0x08, 0x10, 0x20, 0x40, 0x80, 0x1b, 0x36];

        /**
         * AES block cipher algorithm.
         */
        var AES = C_algo.AES = BlockCipher.extend({
            _doReset: function () {
                // Skip reset of nRounds has been set before and key did not change
                if (this._nRounds && this._keyPriorReset === this._key) {
                    return;
                }

                // Shortcuts
                var key = this._keyPriorReset = this._key;
                var keyWords = key.words;
                var keySize = key.sigBytes / 4;

                // Compute number of rounds
                var nRounds = this._nRounds = keySize + 6;

                // Compute number of key schedule rows
                var ksRows = (nRounds + 1) * 4;

                // Compute key schedule
                var keySchedule = this._keySchedule = [];
                for (var ksRow = 0; ksRow < ksRows; ksRow++) {
                    if (ksRow < keySize) {
                        keySchedule[ksRow] = keyWords[ksRow];
                    } else {
                        var t = keySchedule[ksRow - 1];

                        if (!(ksRow % keySize)) {
                            // Rot word
                            t = (t << 8) | (t >>> 24);

                            // Sub word
                            t = (SBOX[t >>> 24] << 24) | (SBOX[(t >>> 16) & 0xff] << 16) | (SBOX[(t >>> 8) & 0xff] << 8) | SBOX[t & 0xff];

                            // Mix Rcon
                            t ^= RCON[(ksRow / keySize) | 0] << 24;
                        } else if (keySize > 6 && ksRow % keySize == 4) {
                            // Sub word
                            t = (SBOX[t >>> 24] << 24) | (SBOX[(t >>> 16) & 0xff] << 16) | (SBOX[(t >>> 8) & 0xff] << 8) | SBOX[t & 0xff];
                        }

                        keySchedule[ksRow] = keySchedule[ksRow - keySize] ^ t;
                    }
                }

                // Compute inv key schedule
                var invKeySchedule = this._invKeySchedule = [];
                for (var invKsRow = 0; invKsRow < ksRows; invKsRow++) {
                    var ksRow = ksRows - invKsRow;

                    if (invKsRow % 4) {
                        var t = keySchedule[ksRow];
                    } else {
                        var t = keySchedule[ksRow - 4];
                    }

                    if (invKsRow < 4 || ksRow <= 4) {
                        invKeySchedule[invKsRow] = t;
                    } else {
                        invKeySchedule[invKsRow] = INV_SUB_MIX_0[SBOX[t >>> 24]] ^ INV_SUB_MIX_1[SBOX[(t >>> 16) & 0xff]] ^
                            INV_SUB_MIX_2[SBOX[(t >>> 8) & 0xff]] ^ INV_SUB_MIX_3[SBOX[t & 0xff]];
                    }
                }
            },

            encryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._keySchedule, SUB_MIX_0, SUB_MIX_1, SUB_MIX_2, SUB_MIX_3, SBOX);
            },

            decryptBlock: function (M, offset) {
                // Swap 2nd and 4th rows
                var t = M[offset + 1];
                M[offset + 1] = M[offset + 3];
                M[offset + 3] = t;

                this._doCryptBlock(M, offset, this._invKeySchedule, INV_SUB_MIX_0, INV_SUB_MIX_1, INV_SUB_MIX_2, INV_SUB_MIX_3, INV_SBOX);

                // Inv swap 2nd and 4th rows
                var t = M[offset + 1];
                M[offset + 1] = M[offset + 3];
                M[offset + 3] = t;
            },

            _doCryptBlock: function (M, offset, keySchedule, SUB_MIX_0, SUB_MIX_1, SUB_MIX_2, SUB_MIX_3, SBOX) {
                // Shortcut
                var nRounds = this._nRounds;

                // Get input, add round key
                var s0 = M[offset]     ^ keySchedule[0];
                var s1 = M[offset + 1] ^ keySchedule[1];
                var s2 = M[offset + 2] ^ keySchedule[2];
                var s3 = M[offset + 3] ^ keySchedule[3];

                // Key schedule row counter
                var ksRow = 4;

                // Rounds
                for (var round = 1; round < nRounds; round++) {
                    // Shift rows, sub bytes, mix columns, add round key
                    var t0 = SUB_MIX_0[s0 >>> 24] ^ SUB_MIX_1[(s1 >>> 16) & 0xff] ^ SUB_MIX_2[(s2 >>> 8) & 0xff] ^ SUB_MIX_3[s3 & 0xff] ^ keySchedule[ksRow++];
                    var t1 = SUB_MIX_0[s1 >>> 24] ^ SUB_MIX_1[(s2 >>> 16) & 0xff] ^ SUB_MIX_2[(s3 >>> 8) & 0xff] ^ SUB_MIX_3[s0 & 0xff] ^ keySchedule[ksRow++];
                    var t2 = SUB_MIX_0[s2 >>> 24] ^ SUB_MIX_1[(s3 >>> 16) & 0xff] ^ SUB_MIX_2[(s0 >>> 8) & 0xff] ^ SUB_MIX_3[s1 & 0xff] ^ keySchedule[ksRow++];
                    var t3 = SUB_MIX_0[s3 >>> 24] ^ SUB_MIX_1[(s0 >>> 16) & 0xff] ^ SUB_MIX_2[(s1 >>> 8) & 0xff] ^ SUB_MIX_3[s2 & 0xff] ^ keySchedule[ksRow++];

                    // Update state
                    s0 = t0;
                    s1 = t1;
                    s2 = t2;
                    s3 = t3;
                }

                // Shift rows, sub bytes, add round key
                var t0 = ((SBOX[s0 >>> 24] << 24) | (SBOX[(s1 >>> 16) & 0xff] << 16) | (SBOX[(s2 >>> 8) & 0xff] << 8) | SBOX[s3 & 0xff]) ^ keySchedule[ksRow++];
                var t1 = ((SBOX[s1 >>> 24] << 24) | (SBOX[(s2 >>> 16) & 0xff] << 16) | (SBOX[(s3 >>> 8) & 0xff] << 8) | SBOX[s0 & 0xff]) ^ keySchedule[ksRow++];
                var t2 = ((SBOX[s2 >>> 24] << 24) | (SBOX[(s3 >>> 16) & 0xff] << 16) | (SBOX[(s0 >>> 8) & 0xff] << 8) | SBOX[s1 & 0xff]) ^ keySchedule[ksRow++];
                var t3 = ((SBOX[s3 >>> 24] << 24) | (SBOX[(s0 >>> 16) & 0xff] << 16) | (SBOX[(s1 >>> 8) & 0xff] << 8) | SBOX[s2 & 0xff]) ^ keySchedule[ksRow++];

                // Set output
                M[offset]     = t0;
                M[offset + 1] = t1;
                M[offset + 2] = t2;
                M[offset + 3] = t3;
            },

            keySize: 256/32
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.AES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.AES.decrypt(ciphertext, key, cfg);
         */
        C.AES = BlockCipher._createHelper(AES);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var BlockCipher = C_lib.BlockCipher;
        var C_algo = C.algo;

        // Permuted Choice 1 constants
        var PC1 = [
            57, 49, 41, 33, 25, 17, 9,  1,
            58, 50, 42, 34, 26, 18, 10, 2,
            59, 51, 43, 35, 27, 19, 11, 3,
            60, 52, 44, 36, 63, 55, 47, 39,
            31, 23, 15, 7,  62, 54, 46, 38,
            30, 22, 14, 6,  61, 53, 45, 37,
            29, 21, 13, 5,  28, 20, 12, 4
        ];

        // Permuted Choice 2 constants
        var PC2 = [
            14, 17, 11, 24, 1,  5,
            3,  28, 15, 6,  21, 10,
            23, 19, 12, 4,  26, 8,
            16, 7,  27, 20, 13, 2,
            41, 52, 31, 37, 47, 55,
            30, 40, 51, 45, 33, 48,
            44, 49, 39, 56, 34, 53,
            46, 42, 50, 36, 29, 32
        ];

        // Cumulative bit shift constants
        var BIT_SHIFTS = [1,  2,  4,  6,  8,  10, 12, 14, 15, 17, 19, 21, 23, 25, 27, 28];

        // SBOXes and round permutation constants
        var SBOX_P = [
            {
                0x0: 0x808200,
                0x10000000: 0x8000,
                0x20000000: 0x808002,
                0x30000000: 0x2,
                0x40000000: 0x200,
                0x50000000: 0x808202,
                0x60000000: 0x800202,
                0x70000000: 0x800000,
                0x80000000: 0x202,
                0x90000000: 0x800200,
                0xa0000000: 0x8200,
                0xb0000000: 0x808000,
                0xc0000000: 0x8002,
                0xd0000000: 0x800002,
                0xe0000000: 0x0,
                0xf0000000: 0x8202,
                0x8000000: 0x0,
                0x18000000: 0x808202,
                0x28000000: 0x8202,
                0x38000000: 0x8000,
                0x48000000: 0x808200,
                0x58000000: 0x200,
                0x68000000: 0x808002,
                0x78000000: 0x2,
                0x88000000: 0x800200,
                0x98000000: 0x8200,
                0xa8000000: 0x808000,
                0xb8000000: 0x800202,
                0xc8000000: 0x800002,
                0xd8000000: 0x8002,
                0xe8000000: 0x202,
                0xf8000000: 0x800000,
                0x1: 0x8000,
                0x10000001: 0x2,
                0x20000001: 0x808200,
                0x30000001: 0x800000,
                0x40000001: 0x808002,
                0x50000001: 0x8200,
                0x60000001: 0x200,
                0x70000001: 0x800202,
                0x80000001: 0x808202,
                0x90000001: 0x808000,
                0xa0000001: 0x800002,
                0xb0000001: 0x8202,
                0xc0000001: 0x202,
                0xd0000001: 0x800200,
                0xe0000001: 0x8002,
                0xf0000001: 0x0,
                0x8000001: 0x808202,
                0x18000001: 0x808000,
                0x28000001: 0x800000,
                0x38000001: 0x200,
                0x48000001: 0x8000,
                0x58000001: 0x800002,
                0x68000001: 0x2,
                0x78000001: 0x8202,
                0x88000001: 0x8002,
                0x98000001: 0x800202,
                0xa8000001: 0x202,
                0xb8000001: 0x808200,
                0xc8000001: 0x800200,
                0xd8000001: 0x0,
                0xe8000001: 0x8200,
                0xf8000001: 0x808002
            },
            {
                0x0: 0x40084010,
                0x1000000: 0x4000,
                0x2000000: 0x80000,
                0x3000000: 0x40080010,
                0x4000000: 0x40000010,
                0x5000000: 0x40084000,
                0x6000000: 0x40004000,
                0x7000000: 0x10,
                0x8000000: 0x84000,
                0x9000000: 0x40004010,
                0xa000000: 0x40000000,
                0xb000000: 0x84010,
                0xc000000: 0x80010,
                0xd000000: 0x0,
                0xe000000: 0x4010,
                0xf000000: 0x40080000,
                0x800000: 0x40004000,
                0x1800000: 0x84010,
                0x2800000: 0x10,
                0x3800000: 0x40004010,
                0x4800000: 0x40084010,
                0x5800000: 0x40000000,
                0x6800000: 0x80000,
                0x7800000: 0x40080010,
                0x8800000: 0x80010,
                0x9800000: 0x0,
                0xa800000: 0x4000,
                0xb800000: 0x40080000,
                0xc800000: 0x40000010,
                0xd800000: 0x84000,
                0xe800000: 0x40084000,
                0xf800000: 0x4010,
                0x10000000: 0x0,
                0x11000000: 0x40080010,
                0x12000000: 0x40004010,
                0x13000000: 0x40084000,
                0x14000000: 0x40080000,
                0x15000000: 0x10,
                0x16000000: 0x84010,
                0x17000000: 0x4000,
                0x18000000: 0x4010,
                0x19000000: 0x80000,
                0x1a000000: 0x80010,
                0x1b000000: 0x40000010,
                0x1c000000: 0x84000,
                0x1d000000: 0x40004000,
                0x1e000000: 0x40000000,
                0x1f000000: 0x40084010,
                0x10800000: 0x84010,
                0x11800000: 0x80000,
                0x12800000: 0x40080000,
                0x13800000: 0x4000,
                0x14800000: 0x40004000,
                0x15800000: 0x40084010,
                0x16800000: 0x10,
                0x17800000: 0x40000000,
                0x18800000: 0x40084000,
                0x19800000: 0x40000010,
                0x1a800000: 0x40004010,
                0x1b800000: 0x80010,
                0x1c800000: 0x0,
                0x1d800000: 0x4010,
                0x1e800000: 0x40080010,
                0x1f800000: 0x84000
            },
            {
                0x0: 0x104,
                0x100000: 0x0,
                0x200000: 0x4000100,
                0x300000: 0x10104,
                0x400000: 0x10004,
                0x500000: 0x4000004,
                0x600000: 0x4010104,
                0x700000: 0x4010000,
                0x800000: 0x4000000,
                0x900000: 0x4010100,
                0xa00000: 0x10100,
                0xb00000: 0x4010004,
                0xc00000: 0x4000104,
                0xd00000: 0x10000,
                0xe00000: 0x4,
                0xf00000: 0x100,
                0x80000: 0x4010100,
                0x180000: 0x4010004,
                0x280000: 0x0,
                0x380000: 0x4000100,
                0x480000: 0x4000004,
                0x580000: 0x10000,
                0x680000: 0x10004,
                0x780000: 0x104,
                0x880000: 0x4,
                0x980000: 0x100,
                0xa80000: 0x4010000,
                0xb80000: 0x10104,
                0xc80000: 0x10100,
                0xd80000: 0x4000104,
                0xe80000: 0x4010104,
                0xf80000: 0x4000000,
                0x1000000: 0x4010100,
                0x1100000: 0x10004,
                0x1200000: 0x10000,
                0x1300000: 0x4000100,
                0x1400000: 0x100,
                0x1500000: 0x4010104,
                0x1600000: 0x4000004,
                0x1700000: 0x0,
                0x1800000: 0x4000104,
                0x1900000: 0x4000000,
                0x1a00000: 0x4,
                0x1b00000: 0x10100,
                0x1c00000: 0x4010000,
                0x1d00000: 0x104,
                0x1e00000: 0x10104,
                0x1f00000: 0x4010004,
                0x1080000: 0x4000000,
                0x1180000: 0x104,
                0x1280000: 0x4010100,
                0x1380000: 0x0,
                0x1480000: 0x10004,
                0x1580000: 0x4000100,
                0x1680000: 0x100,
                0x1780000: 0x4010004,
                0x1880000: 0x10000,
                0x1980000: 0x4010104,
                0x1a80000: 0x10104,
                0x1b80000: 0x4000004,
                0x1c80000: 0x4000104,
                0x1d80000: 0x4010000,
                0x1e80000: 0x4,
                0x1f80000: 0x10100
            },
            {
                0x0: 0x80401000,
                0x10000: 0x80001040,
                0x20000: 0x401040,
                0x30000: 0x80400000,
                0x40000: 0x0,
                0x50000: 0x401000,
                0x60000: 0x80000040,
                0x70000: 0x400040,
                0x80000: 0x80000000,
                0x90000: 0x400000,
                0xa0000: 0x40,
                0xb0000: 0x80001000,
                0xc0000: 0x80400040,
                0xd0000: 0x1040,
                0xe0000: 0x1000,
                0xf0000: 0x80401040,
                0x8000: 0x80001040,
                0x18000: 0x40,
                0x28000: 0x80400040,
                0x38000: 0x80001000,
                0x48000: 0x401000,
                0x58000: 0x80401040,
                0x68000: 0x0,
                0x78000: 0x80400000,
                0x88000: 0x1000,
                0x98000: 0x80401000,
                0xa8000: 0x400000,
                0xb8000: 0x1040,
                0xc8000: 0x80000000,
                0xd8000: 0x400040,
                0xe8000: 0x401040,
                0xf8000: 0x80000040,
                0x100000: 0x400040,
                0x110000: 0x401000,
                0x120000: 0x80000040,
                0x130000: 0x0,
                0x140000: 0x1040,
                0x150000: 0x80400040,
                0x160000: 0x80401000,
                0x170000: 0x80001040,
                0x180000: 0x80401040,
                0x190000: 0x80000000,
                0x1a0000: 0x80400000,
                0x1b0000: 0x401040,
                0x1c0000: 0x80001000,
                0x1d0000: 0x400000,
                0x1e0000: 0x40,
                0x1f0000: 0x1000,
                0x108000: 0x80400000,
                0x118000: 0x80401040,
                0x128000: 0x0,
                0x138000: 0x401000,
                0x148000: 0x400040,
                0x158000: 0x80000000,
                0x168000: 0x80001040,
                0x178000: 0x40,
                0x188000: 0x80000040,
                0x198000: 0x1000,
                0x1a8000: 0x80001000,
                0x1b8000: 0x80400040,
                0x1c8000: 0x1040,
                0x1d8000: 0x80401000,
                0x1e8000: 0x400000,
                0x1f8000: 0x401040
            },
            {
                0x0: 0x80,
                0x1000: 0x1040000,
                0x2000: 0x40000,
                0x3000: 0x20000000,
                0x4000: 0x20040080,
                0x5000: 0x1000080,
                0x6000: 0x21000080,
                0x7000: 0x40080,
                0x8000: 0x1000000,
                0x9000: 0x20040000,
                0xa000: 0x20000080,
                0xb000: 0x21040080,
                0xc000: 0x21040000,
                0xd000: 0x0,
                0xe000: 0x1040080,
                0xf000: 0x21000000,
                0x800: 0x1040080,
                0x1800: 0x21000080,
                0x2800: 0x80,
                0x3800: 0x1040000,
                0x4800: 0x40000,
                0x5800: 0x20040080,
                0x6800: 0x21040000,
                0x7800: 0x20000000,
                0x8800: 0x20040000,
                0x9800: 0x0,
                0xa800: 0x21040080,
                0xb800: 0x1000080,
                0xc800: 0x20000080,
                0xd800: 0x21000000,
                0xe800: 0x1000000,
                0xf800: 0x40080,
                0x10000: 0x40000,
                0x11000: 0x80,
                0x12000: 0x20000000,
                0x13000: 0x21000080,
                0x14000: 0x1000080,
                0x15000: 0x21040000,
                0x16000: 0x20040080,
                0x17000: 0x1000000,
                0x18000: 0x21040080,
                0x19000: 0x21000000,
                0x1a000: 0x1040000,
                0x1b000: 0x20040000,
                0x1c000: 0x40080,
                0x1d000: 0x20000080,
                0x1e000: 0x0,
                0x1f000: 0x1040080,
                0x10800: 0x21000080,
                0x11800: 0x1000000,
                0x12800: 0x1040000,
                0x13800: 0x20040080,
                0x14800: 0x20000000,
                0x15800: 0x1040080,
                0x16800: 0x80,
                0x17800: 0x21040000,
                0x18800: 0x40080,
                0x19800: 0x21040080,
                0x1a800: 0x0,
                0x1b800: 0x21000000,
                0x1c800: 0x1000080,
                0x1d800: 0x40000,
                0x1e800: 0x20040000,
                0x1f800: 0x20000080
            },
            {
                0x0: 0x10000008,
                0x100: 0x2000,
                0x200: 0x10200000,
                0x300: 0x10202008,
                0x400: 0x10002000,
                0x500: 0x200000,
                0x600: 0x200008,
                0x700: 0x10000000,
                0x800: 0x0,
                0x900: 0x10002008,
                0xa00: 0x202000,
                0xb00: 0x8,
                0xc00: 0x10200008,
                0xd00: 0x202008,
                0xe00: 0x2008,
                0xf00: 0x10202000,
                0x80: 0x10200000,
                0x180: 0x10202008,
                0x280: 0x8,
                0x380: 0x200000,
                0x480: 0x202008,
                0x580: 0x10000008,
                0x680: 0x10002000,
                0x780: 0x2008,
                0x880: 0x200008,
                0x980: 0x2000,
                0xa80: 0x10002008,
                0xb80: 0x10200008,
                0xc80: 0x0,
                0xd80: 0x10202000,
                0xe80: 0x202000,
                0xf80: 0x10000000,
                0x1000: 0x10002000,
                0x1100: 0x10200008,
                0x1200: 0x10202008,
                0x1300: 0x2008,
                0x1400: 0x200000,
                0x1500: 0x10000000,
                0x1600: 0x10000008,
                0x1700: 0x202000,
                0x1800: 0x202008,
                0x1900: 0x0,
                0x1a00: 0x8,
                0x1b00: 0x10200000,
                0x1c00: 0x2000,
                0x1d00: 0x10002008,
                0x1e00: 0x10202000,
                0x1f00: 0x200008,
                0x1080: 0x8,
                0x1180: 0x202000,
                0x1280: 0x200000,
                0x1380: 0x10000008,
                0x1480: 0x10002000,
                0x1580: 0x2008,
                0x1680: 0x10202008,
                0x1780: 0x10200000,
                0x1880: 0x10202000,
                0x1980: 0x10200008,
                0x1a80: 0x2000,
                0x1b80: 0x202008,
                0x1c80: 0x200008,
                0x1d80: 0x0,
                0x1e80: 0x10000000,
                0x1f80: 0x10002008
            },
            {
                0x0: 0x100000,
                0x10: 0x2000401,
                0x20: 0x400,
                0x30: 0x100401,
                0x40: 0x2100401,
                0x50: 0x0,
                0x60: 0x1,
                0x70: 0x2100001,
                0x80: 0x2000400,
                0x90: 0x100001,
                0xa0: 0x2000001,
                0xb0: 0x2100400,
                0xc0: 0x2100000,
                0xd0: 0x401,
                0xe0: 0x100400,
                0xf0: 0x2000000,
                0x8: 0x2100001,
                0x18: 0x0,
                0x28: 0x2000401,
                0x38: 0x2100400,
                0x48: 0x100000,
                0x58: 0x2000001,
                0x68: 0x2000000,
                0x78: 0x401,
                0x88: 0x100401,
                0x98: 0x2000400,
                0xa8: 0x2100000,
                0xb8: 0x100001,
                0xc8: 0x400,
                0xd8: 0x2100401,
                0xe8: 0x1,
                0xf8: 0x100400,
                0x100: 0x2000000,
                0x110: 0x100000,
                0x120: 0x2000401,
                0x130: 0x2100001,
                0x140: 0x100001,
                0x150: 0x2000400,
                0x160: 0x2100400,
                0x170: 0x100401,
                0x180: 0x401,
                0x190: 0x2100401,
                0x1a0: 0x100400,
                0x1b0: 0x1,
                0x1c0: 0x0,
                0x1d0: 0x2100000,
                0x1e0: 0x2000001,
                0x1f0: 0x400,
                0x108: 0x100400,
                0x118: 0x2000401,
                0x128: 0x2100001,
                0x138: 0x1,
                0x148: 0x2000000,
                0x158: 0x100000,
                0x168: 0x401,
                0x178: 0x2100400,
                0x188: 0x2000001,
                0x198: 0x2100000,
                0x1a8: 0x0,
                0x1b8: 0x2100401,
                0x1c8: 0x100401,
                0x1d8: 0x400,
                0x1e8: 0x2000400,
                0x1f8: 0x100001
            },
            {
                0x0: 0x8000820,
                0x1: 0x20000,
                0x2: 0x8000000,
                0x3: 0x20,
                0x4: 0x20020,
                0x5: 0x8020820,
                0x6: 0x8020800,
                0x7: 0x800,
                0x8: 0x8020000,
                0x9: 0x8000800,
                0xa: 0x20800,
                0xb: 0x8020020,
                0xc: 0x820,
                0xd: 0x0,
                0xe: 0x8000020,
                0xf: 0x20820,
                0x80000000: 0x800,
                0x80000001: 0x8020820,
                0x80000002: 0x8000820,
                0x80000003: 0x8000000,
                0x80000004: 0x8020000,
                0x80000005: 0x20800,
                0x80000006: 0x20820,
                0x80000007: 0x20,
                0x80000008: 0x8000020,
                0x80000009: 0x820,
                0x8000000a: 0x20020,
                0x8000000b: 0x8020800,
                0x8000000c: 0x0,
                0x8000000d: 0x8020020,
                0x8000000e: 0x8000800,
                0x8000000f: 0x20000,
                0x10: 0x20820,
                0x11: 0x8020800,
                0x12: 0x20,
                0x13: 0x800,
                0x14: 0x8000800,
                0x15: 0x8000020,
                0x16: 0x8020020,
                0x17: 0x20000,
                0x18: 0x0,
                0x19: 0x20020,
                0x1a: 0x8020000,
                0x1b: 0x8000820,
                0x1c: 0x8020820,
                0x1d: 0x20800,
                0x1e: 0x820,
                0x1f: 0x8000000,
                0x80000010: 0x20000,
                0x80000011: 0x800,
                0x80000012: 0x8020020,
                0x80000013: 0x20820,
                0x80000014: 0x20,
                0x80000015: 0x8020000,
                0x80000016: 0x8000000,
                0x80000017: 0x8000820,
                0x80000018: 0x8020820,
                0x80000019: 0x8000020,
                0x8000001a: 0x8000800,
                0x8000001b: 0x0,
                0x8000001c: 0x20800,
                0x8000001d: 0x820,
                0x8000001e: 0x20020,
                0x8000001f: 0x8020800
            }
        ];

        // Masks that select the SBOX input
        var SBOX_MASK = [
            0xf8000001, 0x1f800000, 0x01f80000, 0x001f8000,
            0x0001f800, 0x00001f80, 0x000001f8, 0x8000001f
        ];

        /**
         * DES block cipher algorithm.
         */
        var DES = C_algo.DES = BlockCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;

                // Select 56 bits according to PC1
                var keyBits = [];
                for (var i = 0; i < 56; i++) {
                    var keyBitPos = PC1[i] - 1;
                    keyBits[i] = (keyWords[keyBitPos >>> 5] >>> (31 - keyBitPos % 32)) & 1;
                }

                // Assemble 16 subkeys
                var subKeys = this._subKeys = [];
                for (var nSubKey = 0; nSubKey < 16; nSubKey++) {
                    // Create subkey
                    var subKey = subKeys[nSubKey] = [];

                    // Shortcut
                    var bitShift = BIT_SHIFTS[nSubKey];

                    // Select 48 bits according to PC2
                    for (var i = 0; i < 24; i++) {
                        // Select from the left 28 key bits
                        subKey[(i / 6) | 0] |= keyBits[((PC2[i] - 1) + bitShift) % 28] << (31 - i % 6);

                        // Select from the right 28 key bits
                        subKey[4 + ((i / 6) | 0)] |= keyBits[28 + (((PC2[i + 24] - 1) + bitShift) % 28)] << (31 - i % 6);
                    }

                    // Since each subkey is applied to an expanded 32-bit input,
                    // the subkey can be broken into 8 values scaled to 32-bits,
                    // which allows the key to be used without expansion
                    subKey[0] = (subKey[0] << 1) | (subKey[0] >>> 31);
                    for (var i = 1; i < 7; i++) {
                        subKey[i] = subKey[i] >>> ((i - 1) * 4 + 3);
                    }
                    subKey[7] = (subKey[7] << 5) | (subKey[7] >>> 27);
                }

                // Compute inverse subkeys
                var invSubKeys = this._invSubKeys = [];
                for (var i = 0; i < 16; i++) {
                    invSubKeys[i] = subKeys[15 - i];
                }
            },

            encryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._subKeys);
            },

            decryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._invSubKeys);
            },

            _doCryptBlock: function (M, offset, subKeys) {
                // Get input
                this._lBlock = M[offset];
                this._rBlock = M[offset + 1];

                // Initial permutation
                exchangeLR.call(this, 4,  0x0f0f0f0f);
                exchangeLR.call(this, 16, 0x0000ffff);
                exchangeRL.call(this, 2,  0x33333333);
                exchangeRL.call(this, 8,  0x00ff00ff);
                exchangeLR.call(this, 1,  0x55555555);

                // Rounds
                for (var round = 0; round < 16; round++) {
                    // Shortcuts
                    var subKey = subKeys[round];
                    var lBlock = this._lBlock;
                    var rBlock = this._rBlock;

                    // Feistel function
                    var f = 0;
                    for (var i = 0; i < 8; i++) {
                        f |= SBOX_P[i][((rBlock ^ subKey[i]) & SBOX_MASK[i]) >>> 0];
                    }
                    this._lBlock = rBlock;
                    this._rBlock = lBlock ^ f;
                }

                // Undo swap from last round
                var t = this._lBlock;
                this._lBlock = this._rBlock;
                this._rBlock = t;

                // Final permutation
                exchangeLR.call(this, 1,  0x55555555);
                exchangeRL.call(this, 8,  0x00ff00ff);
                exchangeRL.call(this, 2,  0x33333333);
                exchangeLR.call(this, 16, 0x0000ffff);
                exchangeLR.call(this, 4,  0x0f0f0f0f);

                // Set output
                M[offset] = this._lBlock;
                M[offset + 1] = this._rBlock;
            },

            keySize: 64/32,

            ivSize: 64/32,

            blockSize: 64/32
        });

        // Swap bits across the left and right words
        function exchangeLR(offset, mask) {
            var t = ((this._lBlock >>> offset) ^ this._rBlock) & mask;
            this._rBlock ^= t;
            this._lBlock ^= t << offset;
        }

        function exchangeRL(offset, mask) {
            var t = ((this._rBlock >>> offset) ^ this._lBlock) & mask;
            this._lBlock ^= t;
            this._rBlock ^= t << offset;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.DES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.DES.decrypt(ciphertext, key, cfg);
         */
        C.DES = BlockCipher._createHelper(DES);

        /**
         * Triple-DES block cipher algorithm.
         */
        var TripleDES = C_algo.TripleDES = BlockCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;

                // Create DES instances
                this._des1 = DES.createEncryptor(WordArray.create(keyWords.slice(0, 2)));
                this._des2 = DES.createEncryptor(WordArray.create(keyWords.slice(2, 4)));
                this._des3 = DES.createEncryptor(WordArray.create(keyWords.slice(4, 6)));
            },

            encryptBlock: function (M, offset) {
                this._des1.encryptBlock(M, offset);
                this._des2.decryptBlock(M, offset);
                this._des3.encryptBlock(M, offset);
            },

            decryptBlock: function (M, offset) {
                this._des3.decryptBlock(M, offset);
                this._des2.encryptBlock(M, offset);
                this._des1.decryptBlock(M, offset);
            },

            keySize: 192/32,

            ivSize: 64/32,

            blockSize: 64/32
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.TripleDES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.TripleDES.decrypt(ciphertext, key, cfg);
         */
        C.TripleDES = BlockCipher._createHelper(TripleDES);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        /**
         * RC4 stream cipher algorithm.
         */
        var RC4 = C_algo.RC4 = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;
                var keySigBytes = key.sigBytes;

                // Init sbox
                var S = this._S = [];
                for (var i = 0; i < 256; i++) {
                    S[i] = i;
                }

                // Key setup
                for (var i = 0, j = 0; i < 256; i++) {
                    var keyByteIndex = i % keySigBytes;
                    var keyByte = (keyWords[keyByteIndex >>> 2] >>> (24 - (keyByteIndex % 4) * 8)) & 0xff;

                    j = (j + S[i] + keyByte) % 256;

                    // Swap
                    var t = S[i];
                    S[i] = S[j];
                    S[j] = t;
                }

                // Counters
                this._i = this._j = 0;
            },

            _doProcessBlock: function (M, offset) {
                M[offset] ^= generateKeystreamWord.call(this);
            },

            keySize: 256/32,

            ivSize: 0
        });

        function generateKeystreamWord() {
            // Shortcuts
            var S = this._S;
            var i = this._i;
            var j = this._j;

            // Generate keystream word
            var keystreamWord = 0;
            for (var n = 0; n < 4; n++) {
                i = (i + 1) % 256;
                j = (j + S[i]) % 256;

                // Swap
                var t = S[i];
                S[i] = S[j];
                S[j] = t;

                keystreamWord |= S[(S[i] + S[j]) % 256] << (24 - n * 8);
            }

            // Update counters
            this._i = i;
            this._j = j;

            return keystreamWord;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RC4.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RC4.decrypt(ciphertext, key, cfg);
         */
        C.RC4 = StreamCipher._createHelper(RC4);

        /**
         * Modified RC4 stream cipher algorithm.
         */
        var RC4Drop = C_algo.RC4Drop = RC4.extend({
            /**
             * Configuration options.
             *
             * @property {number} drop The number of keystream words to drop. Default 192
             */
            cfg: RC4.cfg.extend({
                drop: 192
            }),

            _doReset: function () {
                RC4._doReset.call(this);

                // Drop
                for (var i = this.cfg.drop; i > 0; i--) {
                    generateKeystreamWord.call(this);
                }
            }
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RC4Drop.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RC4Drop.decrypt(ciphertext, key, cfg);
         */
        C.RC4Drop = StreamCipher._createHelper(RC4Drop);
    }());


    /** @preserve
     * Counter block mode compatible with  Dr Brian Gladman fileenc.c
     * derived from CryptoJS.mode.CTR
     * Jan Hruby jhruby.web@gmail.com
     */
    CryptoJS.mode.CTRGladman = (function () {
        var CTRGladman = CryptoJS.lib.BlockCipherMode.extend();

        function incWord(word)
        {
            if (((word >> 24) & 0xff) === 0xff) { //overflow
                var b1 = (word >> 16)&0xff;
                var b2 = (word >> 8)&0xff;
                var b3 = word & 0xff;

                if (b1 === 0xff) // overflow b1
                {
                    b1 = 0;
                    if (b2 === 0xff)
                    {
                        b2 = 0;
                        if (b3 === 0xff)
                        {
                            b3 = 0;
                        }
                        else
                        {
                            ++b3;
                        }
                    }
                    else
                    {
                        ++b2;
                    }
                }
                else
                {
                    ++b1;
                }

                word = 0;
                word += (b1 << 16);
                word += (b2 << 8);
                word += b3;
            }
            else
            {
                word += (0x01 << 24);
            }
            return word;
        }

        function incCounter(counter)
        {
            if ((counter[0] = incWord(counter[0])) === 0)
            {
                // encr_data in fileenc.c from  Dr Brian Gladman's counts only with DWORD j < 8
                counter[1] = incWord(counter[1]);
            }
            return counter;
        }

        var Encryptor = CTRGladman.Encryptor = CTRGladman.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var counter = this._counter;

                // Generate keystream
                if (iv) {
                    counter = this._counter = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }

                incCounter(counter);

                var keystream = counter.slice(0);
                cipher.encryptBlock(keystream, 0);

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        CTRGladman.Decryptor = Encryptor;

        return CTRGladman;
    }());




    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        // Reusable objects
        var S  = [];
        var C_ = [];
        var G  = [];

        /**
         * Rabbit stream cipher algorithm
         */
        var Rabbit = C_algo.Rabbit = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var K = this._key.words;
                var iv = this.cfg.iv;

                // Swap endian
                for (var i = 0; i < 4; i++) {
                    K[i] = (((K[i] << 8)  | (K[i] >>> 24)) & 0x00ff00ff) |
                        (((K[i] << 24) | (K[i] >>> 8))  & 0xff00ff00);
                }

                // Generate initial state values
                var X = this._X = [
                    K[0], (K[3] << 16) | (K[2] >>> 16),
                    K[1], (K[0] << 16) | (K[3] >>> 16),
                    K[2], (K[1] << 16) | (K[0] >>> 16),
                    K[3], (K[2] << 16) | (K[1] >>> 16)
                ];

                // Generate initial counter values
                var C = this._C = [
                    (K[2] << 16) | (K[2] >>> 16), (K[0] & 0xffff0000) | (K[1] & 0x0000ffff),
                    (K[3] << 16) | (K[3] >>> 16), (K[1] & 0xffff0000) | (K[2] & 0x0000ffff),
                    (K[0] << 16) | (K[0] >>> 16), (K[2] & 0xffff0000) | (K[3] & 0x0000ffff),
                    (K[1] << 16) | (K[1] >>> 16), (K[3] & 0xffff0000) | (K[0] & 0x0000ffff)
                ];

                // Carry bit
                this._b = 0;

                // Iterate the system four times
                for (var i = 0; i < 4; i++) {
                    nextState.call(this);
                }

                // Modify the counters
                for (var i = 0; i < 8; i++) {
                    C[i] ^= X[(i + 4) & 7];
                }

                // IV setup
                if (iv) {
                    // Shortcuts
                    var IV = iv.words;
                    var IV_0 = IV[0];
                    var IV_1 = IV[1];

                    // Generate four subvectors
                    var i0 = (((IV_0 << 8) | (IV_0 >>> 24)) & 0x00ff00ff) | (((IV_0 << 24) | (IV_0 >>> 8)) & 0xff00ff00);
                    var i2 = (((IV_1 << 8) | (IV_1 >>> 24)) & 0x00ff00ff) | (((IV_1 << 24) | (IV_1 >>> 8)) & 0xff00ff00);
                    var i1 = (i0 >>> 16) | (i2 & 0xffff0000);
                    var i3 = (i2 << 16)  | (i0 & 0x0000ffff);

                    // Modify counter values
                    C[0] ^= i0;
                    C[1] ^= i1;
                    C[2] ^= i2;
                    C[3] ^= i3;
                    C[4] ^= i0;
                    C[5] ^= i1;
                    C[6] ^= i2;
                    C[7] ^= i3;

                    // Iterate the system four times
                    for (var i = 0; i < 4; i++) {
                        nextState.call(this);
                    }
                }
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var X = this._X;

                // Iterate the system
                nextState.call(this);

                // Generate four keystream words
                S[0] = X[0] ^ (X[5] >>> 16) ^ (X[3] << 16);
                S[1] = X[2] ^ (X[7] >>> 16) ^ (X[5] << 16);
                S[2] = X[4] ^ (X[1] >>> 16) ^ (X[7] << 16);
                S[3] = X[6] ^ (X[3] >>> 16) ^ (X[1] << 16);

                for (var i = 0; i < 4; i++) {
                    // Swap endian
                    S[i] = (((S[i] << 8)  | (S[i] >>> 24)) & 0x00ff00ff) |
                        (((S[i] << 24) | (S[i] >>> 8))  & 0xff00ff00);

                    // Encrypt
                    M[offset + i] ^= S[i];
                }
            },

            blockSize: 128/32,

            ivSize: 64/32
        });

        function nextState() {
            // Shortcuts
            var X = this._X;
            var C = this._C;

            // Save old counter values
            for (var i = 0; i < 8; i++) {
                C_[i] = C[i];
            }

            // Calculate new counter values
            C[0] = (C[0] + 0x4d34d34d + this._b) | 0;
            C[1] = (C[1] + 0xd34d34d3 + ((C[0] >>> 0) < (C_[0] >>> 0) ? 1 : 0)) | 0;
            C[2] = (C[2] + 0x34d34d34 + ((C[1] >>> 0) < (C_[1] >>> 0) ? 1 : 0)) | 0;
            C[3] = (C[3] + 0x4d34d34d + ((C[2] >>> 0) < (C_[2] >>> 0) ? 1 : 0)) | 0;
            C[4] = (C[4] + 0xd34d34d3 + ((C[3] >>> 0) < (C_[3] >>> 0) ? 1 : 0)) | 0;
            C[5] = (C[5] + 0x34d34d34 + ((C[4] >>> 0) < (C_[4] >>> 0) ? 1 : 0)) | 0;
            C[6] = (C[6] + 0x4d34d34d + ((C[5] >>> 0) < (C_[5] >>> 0) ? 1 : 0)) | 0;
            C[7] = (C[7] + 0xd34d34d3 + ((C[6] >>> 0) < (C_[6] >>> 0) ? 1 : 0)) | 0;
            this._b = (C[7] >>> 0) < (C_[7] >>> 0) ? 1 : 0;

            // Calculate the g-values
            for (var i = 0; i < 8; i++) {
                var gx = X[i] + C[i];

                // Construct high and low argument for squaring
                var ga = gx & 0xffff;
                var gb = gx >>> 16;

                // Calculate high and low result of squaring
                var gh = ((((ga * ga) >>> 17) + ga * gb) >>> 15) + gb * gb;
                var gl = (((gx & 0xffff0000) * gx) | 0) + (((gx & 0x0000ffff) * gx) | 0);

                // High XOR low
                G[i] = gh ^ gl;
            }

            // Calculate new state values
            X[0] = (G[0] + ((G[7] << 16) | (G[7] >>> 16)) + ((G[6] << 16) | (G[6] >>> 16))) | 0;
            X[1] = (G[1] + ((G[0] << 8)  | (G[0] >>> 24)) + G[7]) | 0;
            X[2] = (G[2] + ((G[1] << 16) | (G[1] >>> 16)) + ((G[0] << 16) | (G[0] >>> 16))) | 0;
            X[3] = (G[3] + ((G[2] << 8)  | (G[2] >>> 24)) + G[1]) | 0;
            X[4] = (G[4] + ((G[3] << 16) | (G[3] >>> 16)) + ((G[2] << 16) | (G[2] >>> 16))) | 0;
            X[5] = (G[5] + ((G[4] << 8)  | (G[4] >>> 24)) + G[3]) | 0;
            X[6] = (G[6] + ((G[5] << 16) | (G[5] >>> 16)) + ((G[4] << 16) | (G[4] >>> 16))) | 0;
            X[7] = (G[7] + ((G[6] << 8)  | (G[6] >>> 24)) + G[5]) | 0;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.Rabbit.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.Rabbit.decrypt(ciphertext, key, cfg);
         */
        C.Rabbit = StreamCipher._createHelper(Rabbit);
    }());


    /**
     * Counter block mode.
     */
    CryptoJS.mode.CTR = (function () {
        var CTR = CryptoJS.lib.BlockCipherMode.extend();

        var Encryptor = CTR.Encryptor = CTR.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var counter = this._counter;

                // Generate keystream
                if (iv) {
                    counter = this._counter = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }
                var keystream = counter.slice(0);
                cipher.encryptBlock(keystream, 0);

                // Increment counter
                counter[blockSize - 1] = (counter[blockSize - 1] + 1) | 0

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        CTR.Decryptor = Encryptor;

        return CTR;
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        // Reusable objects
        var S  = [];
        var C_ = [];
        var G  = [];

        /**
         * Rabbit stream cipher algorithm.
         *
         * This is a legacy version that neglected to convert the key to little-endian.
         * This error doesn't affect the cipher's security,
         * but it does affect its compatibility with other implementations.
         */
        var RabbitLegacy = C_algo.RabbitLegacy = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var K = this._key.words;
                var iv = this.cfg.iv;

                // Generate initial state values
                var X = this._X = [
                    K[0], (K[3] << 16) | (K[2] >>> 16),
                    K[1], (K[0] << 16) | (K[3] >>> 16),
                    K[2], (K[1] << 16) | (K[0] >>> 16),
                    K[3], (K[2] << 16) | (K[1] >>> 16)
                ];

                // Generate initial counter values
                var C = this._C = [
                    (K[2] << 16) | (K[2] >>> 16), (K[0] & 0xffff0000) | (K[1] & 0x0000ffff),
                    (K[3] << 16) | (K[3] >>> 16), (K[1] & 0xffff0000) | (K[2] & 0x0000ffff),
                    (K[0] << 16) | (K[0] >>> 16), (K[2] & 0xffff0000) | (K[3] & 0x0000ffff),
                    (K[1] << 16) | (K[1] >>> 16), (K[3] & 0xffff0000) | (K[0] & 0x0000ffff)
                ];

                // Carry bit
                this._b = 0;

                // Iterate the system four times
                for (var i = 0; i < 4; i++) {
                    nextState.call(this);
                }

                // Modify the counters
                for (var i = 0; i < 8; i++) {
                    C[i] ^= X[(i + 4) & 7];
                }

                // IV setup
                if (iv) {
                    // Shortcuts
                    var IV = iv.words;
                    var IV_0 = IV[0];
                    var IV_1 = IV[1];

                    // Generate four subvectors
                    var i0 = (((IV_0 << 8) | (IV_0 >>> 24)) & 0x00ff00ff) | (((IV_0 << 24) | (IV_0 >>> 8)) & 0xff00ff00);
                    var i2 = (((IV_1 << 8) | (IV_1 >>> 24)) & 0x00ff00ff) | (((IV_1 << 24) | (IV_1 >>> 8)) & 0xff00ff00);
                    var i1 = (i0 >>> 16) | (i2 & 0xffff0000);
                    var i3 = (i2 << 16)  | (i0 & 0x0000ffff);

                    // Modify counter values
                    C[0] ^= i0;
                    C[1] ^= i1;
                    C[2] ^= i2;
                    C[3] ^= i3;
                    C[4] ^= i0;
                    C[5] ^= i1;
                    C[6] ^= i2;
                    C[7] ^= i3;

                    // Iterate the system four times
                    for (var i = 0; i < 4; i++) {
                        nextState.call(this);
                    }
                }
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var X = this._X;

                // Iterate the system
                nextState.call(this);

                // Generate four keystream words
                S[0] = X[0] ^ (X[5] >>> 16) ^ (X[3] << 16);
                S[1] = X[2] ^ (X[7] >>> 16) ^ (X[5] << 16);
                S[2] = X[4] ^ (X[1] >>> 16) ^ (X[7] << 16);
                S[3] = X[6] ^ (X[3] >>> 16) ^ (X[1] << 16);

                for (var i = 0; i < 4; i++) {
                    // Swap endian
                    S[i] = (((S[i] << 8)  | (S[i] >>> 24)) & 0x00ff00ff) |
                        (((S[i] << 24) | (S[i] >>> 8))  & 0xff00ff00);

                    // Encrypt
                    M[offset + i] ^= S[i];
                }
            },

            blockSize: 128/32,

            ivSize: 64/32
        });

        function nextState() {
            // Shortcuts
            var X = this._X;
            var C = this._C;

            // Save old counter values
            for (var i = 0; i < 8; i++) {
                C_[i] = C[i];
            }

            // Calculate new counter values
            C[0] = (C[0] + 0x4d34d34d + this._b) | 0;
            C[1] = (C[1] + 0xd34d34d3 + ((C[0] >>> 0) < (C_[0] >>> 0) ? 1 : 0)) | 0;
            C[2] = (C[2] + 0x34d34d34 + ((C[1] >>> 0) < (C_[1] >>> 0) ? 1 : 0)) | 0;
            C[3] = (C[3] + 0x4d34d34d + ((C[2] >>> 0) < (C_[2] >>> 0) ? 1 : 0)) | 0;
            C[4] = (C[4] + 0xd34d34d3 + ((C[3] >>> 0) < (C_[3] >>> 0) ? 1 : 0)) | 0;
            C[5] = (C[5] + 0x34d34d34 + ((C[4] >>> 0) < (C_[4] >>> 0) ? 1 : 0)) | 0;
            C[6] = (C[6] + 0x4d34d34d + ((C[5] >>> 0) < (C_[5] >>> 0) ? 1 : 0)) | 0;
            C[7] = (C[7] + 0xd34d34d3 + ((C[6] >>> 0) < (C_[6] >>> 0) ? 1 : 0)) | 0;
            this._b = (C[7] >>> 0) < (C_[7] >>> 0) ? 1 : 0;

            // Calculate the g-values
            for (var i = 0; i < 8; i++) {
                var gx = X[i] + C[i];

                // Construct high and low argument for squaring
                var ga = gx & 0xffff;
                var gb = gx >>> 16;

                // Calculate high and low result of squaring
                var gh = ((((ga * ga) >>> 17) + ga * gb) >>> 15) + gb * gb;
                var gl = (((gx & 0xffff0000) * gx) | 0) + (((gx & 0x0000ffff) * gx) | 0);

                // High XOR low
                G[i] = gh ^ gl;
            }

            // Calculate new state values
            X[0] = (G[0] + ((G[7] << 16) | (G[7] >>> 16)) + ((G[6] << 16) | (G[6] >>> 16))) | 0;
            X[1] = (G[1] + ((G[0] << 8)  | (G[0] >>> 24)) + G[7]) | 0;
            X[2] = (G[2] + ((G[1] << 16) | (G[1] >>> 16)) + ((G[0] << 16) | (G[0] >>> 16))) | 0;
            X[3] = (G[3] + ((G[2] << 8)  | (G[2] >>> 24)) + G[1]) | 0;
            X[4] = (G[4] + ((G[3] << 16) | (G[3] >>> 16)) + ((G[2] << 16) | (G[2] >>> 16))) | 0;
            X[5] = (G[5] + ((G[4] << 8)  | (G[4] >>> 24)) + G[3]) | 0;
            X[6] = (G[6] + ((G[5] << 16) | (G[5] >>> 16)) + ((G[4] << 16) | (G[4] >>> 16))) | 0;
            X[7] = (G[7] + ((G[6] << 8)  | (G[6] >>> 24)) + G[5]) | 0;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RabbitLegacy.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RabbitLegacy.decrypt(ciphertext, key, cfg);
         */
        C.RabbitLegacy = StreamCipher._createHelper(RabbitLegacy);
    }());


    /**
     * Zero padding strategy.
     */
    CryptoJS.pad.ZeroPadding = {
        pad: function (data, blockSize) {
            // Shortcut
            var blockSizeBytes = blockSize * 4;

            // Pad
            data.clamp();
            data.sigBytes += blockSizeBytes - ((data.sigBytes % blockSizeBytes) || blockSizeBytes);
        },

        unpad: function (data) {
            // Shortcut
            var dataWords = data.words;

            // Unpad
            var i = data.sigBytes - 1;
            while (!((dataWords[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff)) {
                i--;
            }
            data.sigBytes = i + 1;
        }
    };


    return CryptoJS;

}));</script>

<script>
    // variables to be filled when generating the file
    var encryptedMsg = '450ac4a7a81dd621bf96c562d443f8a01ecde661398d4cfbb11ffd154e06cb129b8334ddb5b76e70bd4a8164b09ae043U2FsdGVkX1+yELFlLgw3AiszMGshNkGolHbMf7C8Npi4xF0aB3SLqN82CJBI8K/ZeIBw2inh7yayEFfBfcJEU3OlNxdxLgoUG02A6qfndY86UimOKTCl82WC0lLrYzUeLbytkzx8hlfImTYu0xsQKrE/DeOnd89LRdSyvuvr+OeLgFWfK5jW4V7I6ghmd+xXpNs617v2yvty4VXVSXsl4aPcR/nLah1WshrwEN0Nj3yTk3E7IoYorVj/CsQ16uNhGH/POh5ZzNrAhgKnZL/mkgaOrVT+KY8WLmv4fCWZ4SUQwG7cSAvzswfLTengrBnXXGDGb1i5C2JOPd8wzdL10P6+2Gm1Jxgea/FOV8TBlJFgCzQjsMEkcI6XGWlyNaX6/LThZkR8/iWW11jc4zJ8xLDJkfXmbs/kflkAp4dEF8t8UYE8sxaxcTz/o8Rm8k4pNml3CIS1fsItBUAPaFbHxkIZOTSyZ8xCtYFIy0OaXswPhFFInB9To7OVJEqSCzLj76ImLLcoxPfSnYK9FJibHIIZK5QcuhRFjY8aghPfYsdIEgffRP4ah0rOlUoh6OHIlCljDbUduqCYnvAVPXvf1xpSImOSpGWyBASYbN3kdcbF0KWrmnfUmhzr+2H0b5J/29eMhimD4nSlv2bir4w2fr1AqorEAsISOlQLujlKmr32uasVvkIc+jFGhB7InJuuvYhcvOaqEmp2BQq+a87eVzORVkVRwaVADjKiwinKKeLPBcCY3IoVxNKYXcSAj8vGIsckdqCz28XLhpcUbo7/2xlprHq8KHTBfj4Uv8/eE2a2b8eZveWBkxcbCFk+dREgnrKakoGocneglTgDBqnevGQE3h7PFTH1IrDVJ/dsinMIuhuEZp3UJ3EYG9zColbS0xkdsAj0m/vA9Y53iZtWtFsKeByTFgL+INLlFHKQt73r/3g27o7NJVaH5WECpzn7WtP3c3mRFuq21Az9w6dTZX/31gmPnW0hTtoFgpkMYKjsK9nJ4uPMs+RkpnuqPNH/GgXzvkdvk9x73O6QkO04HuNCpJcwZ8juDr+3H9jD8lVfLefptXBbWZIfvBMlZyM7JROJ3lMczPOcBCGV5ca4oNoLzhXwKJzKdrjpLOECPaQZQ3Yuhs9f5mRpiAR7s5Dz3ZDTUP/nPFExQUd2MJga8XQb2Ge07NqLTUBrf3gG2wzK5SYw2IqI8Puhh10PT1QYsBpiVxgnJ9z7Hnw3l3AvY7mxrslJPL+PbuVUa7raMRbxXh0vTjkUkqzDpcGROIC+Mn24fmfkVdiImPVwvA5FpPUgWw/rRSL2+6EraXAcGoozxQZNLrI0+z9Og2UMRGjci++XnL/AOJDek7BSaq+smVSIWCeK3+sU6S9vGKAePxb+/4YB1SojCJBRBStmjvKzUhy3fe/+LOeOXT8z0fhMN8UovnEgGiYlEnFkBOrV6Eyanjhh7sDvZKH8yPtTsZWsN6xNtPMbwYvbbPfpjE5OmwuoxNQVLA7LsW8fb0mUfNB0AWsGdYBGH2UXaJR9uD84S8/vxbmmaMiCD8B/oSQxk+T3PqI8yRrtMEPdUylBO9aC/n88PVF4kNdkdWzcPuH2cHaIf+j3zYww2Hck5I72VEYt4axipSwQcoLLxPA6OS7ysHcxQTCV9C7NHSKflcYp7y9/oeaA9THB4cswQ0iMQEC7sZZotmXvLqY1LMOAYSNV0jG37wB6KQmzSgfKkOwAmJ11lzU/PwjO2CDIkiNF60oI+6rvAUZ3gMbWtYNL0I+o4kc4ftF/ddGvDcF0NB0EOmTfCUDgtRw8GfRLdbOYvc1mjWIZcJKFTEkbMiFUvJXo/yRXWBOSSNG7RmtCpFRCDagKC6S/hNI7WucdoBYgcv//nTfuIerIu7AnVvqzg2PxVv00QhCqRnNO64/z3TiuEy0H5ckFusNiJ8EEulxuB4EPvBHkY884Z04Jft4tECvlLwHFwZkDfpYL1FcAoLfe98Jhu6GVyEhbSWrG4MI47JIt3O+QwJIWxdVlpO9cM7OdLFhD7TmvEAC2m4LzHObujpBcdFaWcfYCuy6ymuW4PzXTAFvXiErMAXxqv4plNdGr+9TQxdyWZUWveRBa2KbJCqI4VVJTmLNYfyVdJTk/I+MipVV54pMb4/fyPdu2XN+ATKFfrMLvrHFDas5Ih5t1ihtOMt7KF9ZTVplTNKvRS/byiKL/IYWJl9LZAzyFdisuMxfmWmPcWazTEOBJCncZw0Sgt8698Y/q9oFbzShIfq2g3zmhI21kWLWEFpo9EJCraDwp0B1Xzlr7Qz8di9mt9iLLQP9CTS8+w16Ak27oDjP9c7Vmi+vWiw+vkpWx3dCIod5hlZPUc1W3/vGDCqwKEDokxBKeu/Dt8H2Z5Tyy3QOuxj3t+xo5kTIgQn5C6muEb1U4pYryVaRAfY+TNTOO6HBAcQJD/N9Nnge9NuJ2N/VZN4cBjSldXLKwAErsLDonXwaYJhZ/HyHt8grVe12qGfaOEK2ImcdCM37zoBZKrrRZEP4RuY3fssiXj/dl0Xv3Kcudl0bceKZrX3OKBDjpTa7IPRoBFNyL2gYn3abMmVo/NNySFFCwpmgvtjnkeUz7GxBaOcDwBUbeJyvId7adXaOw1YYLHYJDZ1uRn5/fxsu7vXGi8oq3xknaa5gXNzqQVrEvcNjvHQvjZwA52242EUzN/SHM/UFQ6pBipowlAFbrAZRZVUljkAsD+RUaG0FPOqkn9I1f/E5hBp+rnJPVmuK7k1OiCavbJC5adal06EE8hYAEWvJhJP2T+4qKadkZm3zm5CDmLzrzttnXZ3sLGjVmKXz9kznMtHwOenW8CiXQbZVayYBOSavLY94smLLpi4WN/+2WumbqNHBILWk8aOYII2nbCzKw/8Nyu1LqypHFArXsRgosou5Is+yo3q/KAGBX0KODbdY3xvPtyro+5GD4Pe9U131GFZ/hJLhwrVR8A+Vfwgr+qCQYy6xNg3kwDRcA0nYG8do+7nq01puVqznoGgk6uIkv2iWGIjNRN7gM/GkDMof6TS1UMPis+mQuvyF/fgYToErQQWGgQl0+pwb+z3kcyIkWIQYLd5pDgeXcRWjdDn1X8+0dB50xoVVwUXaiqrcSSn3d+KAE11twxpI9h54OnFcQPzvsyngBAxG+CEpJ34ni+q6tsHx+N28LefxSue4IxrbvqFU2rLXmfjjwGV1sRPwEV8VY97k0ZvrQgCqcoeG8R/duVOJBWDY+p1113RQxr0TpYOSaJjpJjF9sTQ68VV8jxvgeGbOZvF0SOTXRAbqC3SJnA8do20waK1n9HGKu+y6DT47NfH6r1kj65q41+nmVlT+ZwpCo3DWKhbE6eafWBgu4crqfF5WmdOL6zKD6kPxN7gRdj4P25fhXyBKXnPy0bvmVrRGJLUPGT4mR6C+LI1kahETdczUK250E2pR1of2mLBWU2RRIW+swBFh3THyIxauqnGSUL5eNBbXaoAQJ8qFiKbj+/5WDCHwDCPgnRmUyOxhPPDWdc3TpSqAcvVg1Hs6Mm843YOSMgmC73dREgtqXCOEgQ6cVO3ILLBukgCJwvIUwkAPkks8xIdJ2Hjy3A5pn58byQrjRTms834LEz3m/RSINh3YvTvG0VSAzPMSZPitlvSfx8Zm/pv5j7i45x03m5ylUkMysjeZsp30hD2x7ws5oi/Y7r9FqYicO0DdabSnovB5ByKaAoxjE4tISyeXwuef0ch7P8D3SA4gNTYADxojZmO8MNQGUKgnzDnBLCggmAHzAG/Q0a2MCHtoyyMMQk2KIavNrcJri8S90sWX7iqCIhaDbxwe663lqYgKQf8e93EEQ467N7nrhwa9SwqAetz03Rvrx/snaO5NcGvZVjmpaGn+Kb3qinJNP6eAWsvw998KjQUvvzhSQVfcXU1DY6ldeZ5Tx5sRiUNpF/3xthQX0sUjcXYy1ilb/9pVBr8Ux6w95vyNexqDqu+BS2ePOGLzD17+Hd0CJHUFdvbWMRaNCfvAUJXmq5tyJ76znuHJ7vNPG8sf5DXwEmtVxsxOm05ON1+CLqraKXqRTMaCp2/Br0DxB8xCiwFOGztDWZf2z2SYTwDdl0oQYaZb1i4M70BrKrmTUuhwN8acklyRNLDl1YXKODFmhieh0kwAguhSqhZ7SyZSyn1zV24CgFwCYTpsG7xjLfXkEPc0ezFK3+hJiw74zWGT4NKTGQxMMVllKwsUSIrBw7mcSslrmf8HT6oEgnYDQYgzbwliM4HC3oJ4LDoSDqxo2Eoceb/uxLQcIxFbKAutrSWQlv3bcfuCOjr0zhvGvb1cMoLMkriaMuv4Vu6+GuyCp19TW4JkMzY5S5kWk03/1fJDNpRckPUNUbCQwi40pXFSxXyk9nkog8JLrJbnI64v5MeC8I5pZqSIW2t0D7RcKbF6ZORFN0TrCasoS6pBXeAN87fG/xamdtY6vFEz4e5BpO+y+WmAEYcs+3FuKOmnHMx3CGqUXMk+OzDf1bEF8WLVlEVgdcNpUCEQUFFaO5Y3u6TYxISo7AyDFma9WdVHNeGI+B9ebxku4HMMZ0N50LfTbw50KyEu/4omIHxqFXMrh5Gk50WBnHml430D+k4smFGNRiB6A+CpgMDp5M0FwtPBJxyQWDu4AcclxIIjVGcd76wNURwne4nCMPATZkTJMlfj++eCi41SAvJ/tjRbluydejaFvg1vPXFEJdUXPTCOYXam+NPj9Fg/ejMwfCkLndpgQzQgck7RaJ28ym7cyXPRiRgNuo6A/hoYa/tjAHz6NjaHn3cRKmwWuKVLuj8tfdh/AYE1c09ZswvpT0/iqmP9PDR1BHBJhj2+IjBAES11nIgnc9zqKmOlVBn1VahLk+4JXpNCicx4B2XbjzLmnWRIEI2SILbG7waUzeMZ5t1nAxA/WEr4RCxfuA+5Cnd9CqFBJHfJ19XvB46OpRRIiJj8P46f9QcbStekJal4nuBG6MJdZzDoCoIrpHUXrVtm/NRVQ/uKHs75B5YeTQOnNtARlhu/V2LBrzOZ+S1toBtLHXpYqfZ11GM7t7YhaZXPPPuagG7aGeW7oCdSJO5M70Tgq8GAxxEfFslcMnymwAEYCLv7mscUCyiapGjb8u2us9nE/X5JO/aZvKWgd0ExK9xhN6aVE/esaRaTX9RDyu6W0NnsFDIxp05dCHJICF1OY1J75qR/Gpp8QHWzvQhLmT/+oTYiunU6HaHSjbQZ8El3XI78bvmfhnajSS16svYPStz4lV7VLe4bgJbSzQgC58QFePe2XAFLJUseS5b69c01VLN8yXZ75Ide/T89bN8EeX4bT9WcwIltqYYgYRBeJObjsX51wTQXZUxGN01ITuh1FKIdSbJUqeS0FKr8tP9Eu3gpOllOuhuHj8XMi58IprrkEesxVWF+bcvfvs9Q6Cab9lshw/BR0fstTQimPepNCKsuoIble9EY8bggElwVuO699yG05Xh4OTXAGOgRCAP8ho4cVk8b5+yuXlodUbUaOG/emnptft2iPRmNc5eXl0IMqBzqTYayKXucrDuYRmqtvoA/OgHmvnXjH3uGREsrwni+iXMvuZ4OBY4W0NNmFRHrPyRyTlWwILLqH0quA5ucey5F4nMfQIIs0xIEj2dxrCPRJfm/SeXt1g2qqEu0Ypte9f5H/7KfyTNH3sNhXm/hSwjf/jQMHCpgYbtC1VMTOOsfTW3sLy8Vn8t5eYQmGiqt2ajMH+wyQzfaopsRXnb0Od+gUCcP6n4+C7qEsFDD7VunKLBJqz6SS7vjXWhjwQNtYv/90B8KPzzsqzcIHNq+9Ay/QPlHaiAhEe7Kf+5ZPGdvffoK/WE9YVusFN/Q7YxWRLm4scDVPn24dbNHc+iJ5icIufnHwBe81CvOpNP5/J9dDl5x+BQ2c/xEkSkKo6TNTxDP10TT6n0KINpeeg0n1KrSW7I1EEg3szwPmZDK4MnXwHoBtX1WCQpFcPc/3uKKVH77bkragUyzkI1GfUVcgGqkMEJGk29w6C76J7rqbMjDqx8Q6LcBP0TuvXXovIbWURPvPjD0BqClihZThit4vo1bbyiMj2dAb67XL2p31gE9AHM7ePjM3Khlw7Dnn5xg6XPFWbt9NOVvntKUdFg+SYn2i2k4ggBvnEL7nLJfE6ksU7KiLz4RzCweN7jimcW5FCmcTvDmgxApxzPyT4Yt7ozveAme9rZ1W2IdlSv12ILfWjE0Zng/Guj6UpCtOOVMF42Nb5YCOE1wFeuePlCVO/usaG0C+p0sp7s8vrtlnLNH9vVBKobdyQ1Z0E0pNa1eGULojTKGOa/ITee8YszQFIAXF4p5PJKN4+Pf5qMthsTamZXIWyeXppkWhFEW8suQEYk9CeW1+tQp+WyJGu9gnxzLvTZkmz36nVr2MTMM4m+lm5qkQZrjAX7kLFN9uftQr83SmhDDE08zz9+Gkq1FZu41C7iKp8TFkydtQQztNW39TZXOXDvuSFu5qbnu0t6UuXElHx7G+aqG35VWF6+Tfb7k9L5fjT9hpfXMVgXpQ1dlCvDPr9sKA8FmftdTxmtk7CL8GoFu3k+yNGkzydDYm8NWD4xgHQp4zpGtxpEN6Mo2XOF0PR+kkmkBnAKlMDemBj5mS5FJkkgeP3Xtbt/L/zMzn4ShfCnBiQOYv6KK7S6cmvNd1CSzqrlh1/okFhoR1IBTjCR18OTTEE1b0kt2PHjPRwPPFYUV33P9zouFM0K72TzWVk1CWLV/SX3n91l9aNWNqOTp1+D+E92WWdNV5zj18z+uSdvbMzxDGBclmpJuISu7S2ZjWYkH9vLj+l2+gNIeRCnd5s4p8gxjIuzuRuUmtqmTko8eYJUGmeCHOZaFLmu98YpGd4oR9Po/H5i06pGETO5+obyWEus6v5Er6ezCtXvxeXcUEDV/cGak1eo2Y6h6Xj9JuGtPAMwi2GBRS1FUQbbhIX+DxvbRpX9IRlLN6KCKHwbKX1PNNgtN6z791jC12T+0N2MpXBQACwmWz9s7XBLElovg371vPSn5je1QfEdxQy4XmrtKom7HPa+Gju+JUvYQ31WZkz0uVoh4vya8DlrIFiNEGsgBIiqwQworGIuJmbpkDp7S4JjXcersOe94cjfFOsobhY9braGnc1yrdTUT0pJ3tjzacJAq0zWMF5VeXiUJoAw2/uPTbgeaTvFOqLViWOJxsSfTAnu2ggq5M1553793fWxvNqr4hD+5wMLsxIExNKjBcnHYhIAt2Fjv7tbPlMSR2NyAw2yfHRExyEaz594vVQK4T6ujlRwkTe31eMMj4dGPbehxQplJcTynJWInFs8TyT7vjhj5W8Dek26o9JW/a8R+MAG8UcJ4IO+HXObHcE6VOXWYX1E5zMvS7zIIjnbSDC6CZlJKcK5Ar9umBRU5rL3MwLTjELQOCXSq0K3O4xATudHd6+eSEF3g7HUHv/SKs/OvL9wBVUITaG4q4XauilLr02tejOG0cLFvrdSPJO6fqwFZ6Pi+IjMddjy/plUZnI4vO3B38Q/9KThMa/Qsk2PR6xfPOwGAG2k/mw2C0i0GEHIHo1n/2UAUnohzDYWXmOyFQ1LqFK8JfiLh4fW3lafZrmMpYiSATuK/5EfwovV1Ao8uAREuuYnQT+7uZ0fuMLB4rqNyfv1mCa5wwgcwqD8lZhRI7gh4ZARSyhq12pywic/NyZ/7edZgviExjRjn+pc3BRBkNkwvbrdDRmXiKFpvya+66vnpnC2wHEI4odd3LAFBDbplNZJBk4UqGDoI7vIDtjHKttDALpcIPuafoM2EXetq+T+ExNoJIhzvdBp1rax1l8dADyWkU6Ddh/pA9I6jAuYHhheZCblE/qzAJEQM6oJ2iOO0b8mBHyslGZeRRHlEr2bjNdEM46DOJqLQg6xBsoD7nYnrJf//C/jc2QNSUT0IoTgj/64M9JhdSBIi7i+FAXRSIq/3RFjN7bsMz3PrxnWpQSXcy1yLZdII/up4EXfh9429oZtW1cFiU/lTKbZrxPgu/hPdjOjQJnarY3x3B75BVPLJQg9PRtsH9jdrq6aA6Nd4tHkIrJXaAg7TXknpjc4up6BKNrASh/p9Ux8qD5MRWjTwjyeB6qLfrXdPwjXf6j+pdAGzsnNw9Z7CnYWe+eqFdIXYqfh5DcUW2y660pveuCjfCaNnNAKPiGSUjMeZRn1Htgo8S509SUFczBOVPVDQqncuw9jUvQmEjPBQVoxF2/d9xM40Md4cliXxmxpmEmVXI2XBFSae7uP1dfn3taPlY33pTkArCkFyzXpPvxkjzjaKpvICyCDOAjLcNCMisDz+Wh6PghZFvRToqOKBjHpEu+u5VgrRXtmiaEa4EFl1RI5mwwWHo7G7fm08JQMnvrh9Z8+/jqcGHomWn1BwFEn25qDFsUlwLLSbqwqtBM4Ffe8mlWDutiqQ5O0yiHoYdqwbEMigFtdpALQWRkx1pYjDgZGl90arnRZKRT/qtkk/+GN0iyV5C8TEqFYzDq3hU6UsxCHJM2SAFqd6p/Hbo6vHlEnLXc7rqsZtaqU5ZGKQ39rekSKHpCXOG9D7byd/L0nGDnPErfHoJ3yMtHYFdY9E7Fe2PQwEdiS8obc/GDdGm/DdyKE9mhpiRIPKFTP95+OlU3Sl0Qgid3aRHN7poY0SpLr5i6a1M1F5IJjdt1eAhaiwoE1jU6ElpbXswjowYohvw/+csrp36WBhAA+GsPZsAvEn3+xnp9CpoJdCrZKDU0LRuRQD35L6mIJCitCGF70WNFfrpIGGpiBKUzBSptpNDvaInddX5/v+A0/E3jtjtYOeEHtydc04aZ6jNtOyoaMOtvoCWRBBDhzsGGALCQdfBS7YiphxZ/mi8aWaHrVLLHFBq7CsxxJkkG0pIH9piz9lTK29wPuw1Rr4RRky01sj68eo6YWaZkJlFJkT8slUZeKcc3tS7r0KezFi83sEC9thqFTIW6LFyO/a81MQMeIwDqZaNTYH9JvmUy7Gv4iGLxiCsNZA5QLNbAG9hdkGi0HIt5XqGVUgHPZX14SivySkqnWJRbrttvywvc1mr98PKdOtrgH++e1P2qSDjZB8Rn48lVpil+FNQ2j0XaOU/TOwMqDRKxtlSvJ7IfcwLVcpxTW7xY36ZSACS9voprWHnrDm01iwdzIpH9VJdhQDTRZhgqSrY7SE03gsqEWH6H8MfeKnzZv9VbUf9W1n6ShNAXh4KWaGjD6f0YkJZ3VOyHC/jWuMoRU2TVFRH4mD34viLBibG+/ZdrowV90S8oKLoIOX0F1cb+fPTsnqAVEGGGZfa2WuRJmS8ce6EDMO4NNQIKTagLZ4LDtt4LMEQMkzAmVOx+W7Oih045bRgI4SoPMBs7YB8jsxnQ5s8dpYZhnBL/nu4jZU3xGujs9XLlSqkPm9+JzMbKuI9I9aEkTzIn2TD3Y8vanNZ/lOuZSjAKtGL/TK27F//gmMz9EqDx+w/FF+8OWiLCUdkLzrFk3tUuWkilH1LfBesvOZmEm+Mnnb0BL5JI2bUUiVM80B0HHC/UnTL17M5nu42cifdkYqRo/vhT5mF2VHfJC8gWW4YsauWZd9d1VfKWUFMRzOVA+aBNALqGtqq/LafaPWm/ZLHif7hC3HMOCbH+pIGl3gXfipADlwYoMdH5je3V/pWjUSZ4xPYqYpPUo0bYNYdXAIWIzoqayKehuH+0uDqFTcYN4F0j4ftEj9/nP0OSf8ltmG1YOJ+I1mnb70NmsDEUO8PZnYFPj+b7E68msWxEgvgbq61/CDBTKxj/WO/msuU0mPSeorJusM3Dpr4qQrKSoaGzlLTHQHFDjMO8J2yNTZ2zkFZ1JCqhLQOleyWOVa3lZfok9kiR1/q4sPyGXFjfyYy+WhLdXTZu5xMkQC2Wig0j9OJxni9WocnSEbZLxiPM/Itlsz+BvXOK3DlMXzIsJINbv96XEEZofLSffqd1idefB3rBmj1EppEOOElkxPGCR3lBzbbF4cvA7eC3/AEDhFfAiNIROP9OLxCCoh2YmUaNnk3QyUJG3GSCaoObhqmB1qm8WafnVeP/rZ2vLpWMSAey2w9KtDAL/pzYlc2qplwa5Q2PHWrQS5UgfK1XgvLjh+JwrzlbFylIQlb5S99lk6OFzZr9+E+J8eBhDyqC/Xo5PvWEROQI0FCz8GsWIzTYTW4DUPo21ZrIF66D+AclL7AlvIhoRQZG+yLyAh0reEKcxbUlI+VqIRFcvTXsyTqVdaW8Af8SvN9Di8ouwQhXVC1LeE1FfcQzmR4V1CaIXV03dXfzqxWoT8ODLknQfLP7yErD6udvbW5N+5JPWsahyTPlABm+KuW/LlINKJSONRthybGnB/oKm261SBjPItxUc2uwZTRSx6MthDRcuTzOBma2Ygc4nRTKcRzBeAxVZVKIxgzvaVOPW8lDdFb+Mld70R2O1yj+ZkvOwhq8ornlBm1AFzFsVqCF46RO0orLhI2EHGrX4DsQVajx81QNh9EZ3c5KgYJcG+OJkgdD0iYiL9TKoSvyROPxWaHWaDCs8uFDzcv6/oU20yBRjM1E2AZ+SVqa5KpA8rSZyeC9fPFJWHyqimSM3uWkod9UMVn5W/2puh4qaqamMDcpx4bY4QxYZlQ256zBqqUfoQMYWkmZc3TrWgxd9Z1YF440sIfVCS95Qj/RTFDaL7FFcd6vQCWTwEuylEJtSdk6v3A8kf5PVZnjNtYRK6Nc3hFuzuzeLhdZHFZE5GsZIbUTfiVJAfaVhUoVgi8PrTVuPy8SiTyNlqP0VJM71glgt9SQfCFHtFFk0V0puGcCpxDgeEr2EtpSXlxCrh9SbwXBBLiRXZ4gD5qNTv2XygrcYAVUexrIvAmrGotVkHTpnJGmTyLGzE7fSpUTXw9+4wFmOptYfwpGfPCdZGDb1ET48+hAL1HpS/BbI/UwMa3cUJFGnEHUD+Ifezfz0mn6lqwmAdleh0TJK76EGnXbDLONG1UNyU7Y7UM8WSJzstMsqZSmrCI6Aqb0LJoQWompxKU3Td2nVrJyEg2Yk0eyLu+PI0GxvBJpnpaScl+AmUD0yNe/ZThkoPrMMNn3wT5T/1WH7C5iTuGeRzxE6jOelArnKjyCqfeLAJ/yj3cf8jzhIw4JlummRqjeNCgkydXJlAQo6se8Lgh8Np4CxddBxJ4+jCd6gROGtqw0H1EqibYqttOjmpJx+97QTNzYKrVBlnBZnqD2aPBtdzUQir3d1sE0mfBK3qohd0K90JT40TvQJTK3gvRDTJzpqk0aKCkkFrA+HWf/2G/Smqq1xM3o11EAzQNuhM3QWR0GB1vs1RLCAIwOHjWh3LHIm90BffsbyEq2joyB7XK8uCaJjV05bGduHs41GhM4vt9TbGP6Lcv2PIfXKR5C5x5CXc7CBiKefN4aGmJxEU1XOoFP40XFIuLPoQH7rK9KLQlky3wNkqIcWP+Y4gjC8OWsoGXSia9x0Lw2+hU+rzeWuHHgZ9Faiidlt7XocJ1U/RPz3sUXVfKv2QvT/+ZKwQzCQRKaX3X9xXsx3NoERpFNh1w8vAhkgbJJqnf8aVGXl+CD1gzt1ocFkWd3fVVMp838dQJ7Ond1O7OZCbSVkIl+PevSFqVkYC7Ac/JHI2sy3SHTDkszUuIBSYRtPd9WqQEc8dxOocb9tGor7a8M0D1eQE66uDmadYObgtiDOICVcN0aeY78sl9o7xLSHqZOQGmPAhaZfJhBHfZ1bAAGdyMa/8jiLF0bBNPtN2h5zph8FoKXaGWAvtMhHqM6TrQWSwICTKMTf9wbqRMsrh2RxRAQBaRcCDDiVS9HH2EwygxpbGYHwh4fLygsUmAV4dyqsJxs4O1gjDZUGtFPScPTv2EjdWhNUA+XvU0MGhJNw+kOlMm/sOb5q9wq0udVpp31WcQwHC+5umVzS5QIPGI1MeuDGzdvOlvcETL9HZlY6StH/1NgnIltbJYzn7qCiYJ2Y9N+50enYGdmMjBLLou9wYcQyhLCGGlCLPZXQcQCtOC0kijIEsEll9A94twbb0Gqs4gV2C4OCcVqzA6Ek+IKFXIq8avftoYPV4/OFm2NeOELzeNyvxDWaGVohH3AMSAsAIOgRA3O/G/r5VTwZy+AfrVSYC1Yr3OdbiUxduG/pVcSm0ySm3RKcIAtkaV8bW3q5NeZNmGT8bcq0ZQZ1EhH3u0Sjn6aPa1OopdUa0pMlfe7+Hwg+sg735Ml2jOv04OY7zI8dqYYogrpHOC6lYWaqWY5Yq+NLGFELDO6bfkLesgrOSMH3j2ltpKYNp/DaJ/3U0XAeQkGYS06jwj/NvzhYGjnAkFkXm/oZO9JcAgRrPKdKwL9XKQc39EezKopbLppjqtIzqQ35xrqdSZESH7+aNy2CV58zCN9ynvA+/syAojNOs0ZPWB6jfGU9XH8m1+kHaLfvHLVAS3fL2IVP2DYIwMOdO5VWHMG8wPUqaRqKKN8EPUCy171g4p2YOSRXVboRYBxC0v+W8IF9RuA0LNWrWjYTZKV3yg6SbqNS0yEphD2vWMvJBpLkv2PyF51cAtH9JaN+QhDkjf+Rlhw2GKBqoXhjFop9fYjd2nP+cLvlsokgJ0tBptEIJK/UspuC3iLG6xqhWvCLdlIS7CP3AeVIrikBR5ceSWYZ21PeMsLqPk1RNzuJ/DIYwNEr00ZPV5SbCBcQVzst+UcnuHrr8Ym2wFG5o0i97tRmYWG74uLaidicvcCCJeegm1VjWCVgYevPoUnKm8rIibfWlsN7+dZvGBEwB/E/HTKYVsk7F2IiZvI8mLNjwLixrdX44+B7HANGdqRcuh4BKCcX6SZeOuO3dE9ZsVJ2c9FJOEd5dx87IBHudhCeQ6Pqk2Sdzh4WYk8qMConRZV+Cdr/TS1/pkTWbc48KS++MBkIXapStVhCmT3vMReP4FGkTQylcOp+BYM3pWoxRWPMtRGRCbQs7YEgWujVSfyfq8tjc0BTLGmkEGU52DqpMUbfwjL7cnANyf4eNejqOu9zno9dSnfuZMUmyFSvKeNcNkPv8UGJfJvuWnWzwikXQhXhYlSfyRBCxCDjfY2XlvLoImX1UUnY03LL5HS+d0yPpyzA7MUZs9pyavHdssRJTyquSql5oaa2G3VTlylvjvPJ8GPBZJj5/GIQjmHXIQd+UjR8tYTD4p4Gq3wFi7w40CFkaO/Fa39fJ46R/UKhR/8MeE5qnQFwmOQ1DgTKCmG3aCcS0YB6/+yEeqp6qQy/k6SmE0X/THDcfd6UhUK5qb1eRPge+lKyRkAyki0JxJnk7uGEfibSGzxArwQ3BGCasc2wx/f3KELtqUd0ExY+h0CGz+HZ1T6xfXpmmRidp2rUjaYjOS/rvO4kqVRmxSLKv7xIf4OCFXn5th5wUa/TQCynWIfaEhYbHX2Mo9jVKJ75CUOxn2dp+ilPryxXDOe3taC9T61tEgXghJKB2U5/N/FHTS/qK8BfINF75Vib0N81+eKupynUmobypqECK8FH6OEQjMO9nYotBgi3z9rxEN3mjDOcKNwEYBpupB35WZDvpdfnT9gEox6InAYQw+8Ur+NwLMi0rBwgi9KAxEhjc5dEz0tW4ZKEZAVnGY3m5LzNxz0eThUEtVkJxfh2a9ZXz7SNG9H72YOg81hlKhvewZA34wXct5n1bW7osTmVntQvl7Dy/2nrCbY7IEQijGSbslF9kkkSMWyDsUsyAsXuBEFYVaNdKkgOEQZygvaqGwszrQToDqQPR+XR2YsL3TUVEh77T0PCQ5cjtqSgecmkQGVz06kd2+IrpgIY39oYGTKuNRxxZMf/1VZ96XEUWD4GVdqeMpUyCvsnCxzDAjLqnt2+s6c5ssLyZaNwA94bosiiOSerwt4iGczsHXCDYgh+v7cyHHRS3YFVI+lL+DDyTbMGA46nJCUAzTc1H5gyf2A4PAY2j2weGuHZBGutUTwk4xhITh91l1xGZY8rUd507oeBwqrZwKgzH45dhL5HdLFoMD2KxSu7jYMoDvUoJBcoGsLdx6RaIk0Yrg3EPTbtL6NTf/syskSwBwSV8j6pp4H2kWqyyClsUGRj61MK/7Jqf3cWZ5RF0Acmuo8vkJv5m8G0eQAal6MyrajWOivdCGC7b3I9dlzUxLbJk+5WCAPFL1oKlE+MB0Fnr89OaxImn0+ZZIyb1zKUSMCktcy6lGfWoiSOSd2VQOkSpybdJo70uPIwJloRIx0St5FW7btUJBztQMvETyz9eItmabKA5y0+qWaGlI7Mag0bV0ieLKPmvQ5qwp37zKCQ4vPQjnOyrrPtJ40Dc60egOUtAgTg2ZfV5ZB84f33GJ9J5Mxi2vWGKCZ7qYNPicW7yu1JSF5F51T4PZFhP1DZDo+PIMD0xqBre5toPsH+eLS2P3FGdWZX8fyEiUWiIYKTtihktlwID7H/wofWBKLeef7mqsANeFvDhMPCeEUqN8i2qpqgET/4covAnZlmewxdpzAaHUB6R2jn+uT+xmlOBJ0RlmyNWmHRoAhQK+rCEXtxWcQi1tf/CvDlA1A1whRNqQVEts/RtQez/bYcNPRR1L4/z1IWBcc9A8rJURhLl+xLWinMhzPKo19BCI2yJ3iAcvPidfpXX7awdUbUDaLTfwIp8afh05yQA8X6r6cXaR+pJxuN6xXNesnSWQXajeBqSi71MIMKSVhQX++7YRXLgnp6XuvjSb6tLGfMUyCcnNxoLL40Mr4sRLOClEYIu7k2B0jk6aDJG560NIB1If5LExp7/FB8aLrIW4S+X1d2CBH5T/ZXLZ0pCsh6L2eoqtK65GlAAyPzvMQqmR+RR29aM1OZ75FH2A1TvK62GBNOD+DJ+jDR/ROcbtHsEPahbdwr0IKFwWeAtIRTBs+3+zs2AGTQGK6BSOgJJakIH+l6ZftzHnPs9Gs8VOMkBM+6djOjrHKk24fZXV94ZIgzSR4liuenmLWAZxggNMeNx8SULNNCT1/tP5eo5/boH95n2lByGKepuJK/arNk0r22Qljq/jBIN7zAAYZjCw3QVAMNM7rd91ZBS1marHfPsM6IKrQ33kCvbM44GhIAbQXsoHJiOfXTdeI2UxrKWJyjqVo1M0x3zrSkDlvaOh8w0MmXPBfnNJVqgU7eqg6s51ay2U0KJqifd3LZAGFfjnkzdowrD9Gw8tb4r9Y92VeGw6sDmr/AeAV9z8PuxBrR9+y7Bz1phf/02jW49r9BKOlKt5fe8kNsVMzAJzFld4+tOmZChbif7+NSskcb3OsMGerIis0CA9cXrEUa2DzqDjUJ6iq4N2N106S4wCElineqhUV7S3HZuZB8Xyw1mk9P0+BDLLF4DsljKfDn77fD4k8TtkE76XCZHTXrouHVFogqRIBt9OeTaGzmDpXoJNfwmVSoQSkGwiOcbS6YBiIlzCWsi3ecHyLGTgn6r5578f/fdZv+sU59Xi8VT6Qoa5MaXuLdw5j27544bJChmkCNNoG9+yR+ACj7xSJvQYdjZvSkcDXGYThC3CHbLmevGxdziNBVEBHVXDE1XGKgT+cuPBPLbXl/0j+Gp7tt6JxwK/YlickNvKF+ZBTg/yuRgr2lHfOS9+uBGaJzu+HW3xLakwvNnDaY/eN2Yw3ux6Cle7UdnrvME/R/oDjxBe4T+O10cqKFrIR0dKDmzrzqhdUYR3o7lURmIQCcYqHnKEaDWaFFiEJgiUU0AClEypUG8lDZywrSniClakBKRKh1dRozFKwW0n1W+oBP6qhp3RGEfoxtaPNZpg7yYUtBE0+x08GGVq41jnXAZI2rOFSI/B+Hci91Juq6POUPF+CRT4v9RyxXO7SBvFYeBkeXXv/Kk7G6brSujaoX/aLMhfRkCDOnZi1O1KQONCaUrX1KgRyBwxvN2JMRS6hBe+1S17Cm5L8X75BHuZSb8MipBocdMvyvvqPjzFB5c0AfdWlv+UApReGIFp9ROgidJexnyPceoxGZPTjLl0oE4AqYY66U1FZiuCRFVZfNgdW+N92hFCO88pHkiSMJmm8gUp2h0nOPwbVKdy56yO5oHRfYBKicXCZdLQdPx3ymQ6Z1tIX8QdRnC0RASyioV2sA93QbEYnLwwli4JK0wJxnHyC9c2YX0CLd+NSHXHaNkiGqGix4fzNCD7u7Ifqfgb7Og4xdyBaSJp+pYQos6dWlSasI5JyDDzTEhS/IVTuMaZjaEvI5tfVtLNViviVwXwMv04ZGH0Ye3yI8TUOtbNSUtghi8iNTfaL/lrQGaBZ2nVUT+31cznKvL9ge1GopsC2WPYVpA4089BbczK6zynyt1WOBSfcr102wLoPENYsSHanzupQUGou84niSpWav8aFvggeVx5cwd07XjM3peghNyDXFiYPQ1XKQyuxH1hrHYo07a4xNbD8u3xg3dNkgmtaKUfe/rNlFBrYoQ4FUW7/p1/hzvXR7E1LKUmB9DVeiTh0NCId0U75DFIB6gK1cK4X1gWDv0tXcSReL3qLHkCAJyBZlC1TtvzXYSbcCSlbIouUnfJRXVZhqmgFJfr+OOvLxJX79z80zt9g+pOHuyUrUyEJwcUC2tyM96JbzCy5HifsomI/yTspllwWyN4T/U7pj+PVKOSnldXeGBquk8DHW9cBjpp11LXbRhhkf+aUHPST0NGpq/RwIjgCHx0xbIlbYtRrN3OuMGf8HNgqRa1c7p+016lY3w5TbH1lMeo33ricjDwx6XSzuSLWDWeLnW7cpLCiT8FODO2v3jxU2UuS0i8QOgYuRVtCXFX//4YsmYqSj5HZaUKvz8ketzCq3hsJNr7i8658SLdrwbwHcuh2haPRfcPdopsPHvIIMd5qYy0uVOZKMbgOSef4QIM3jgMkfbjhM2Mt20AtTdnBC57DZD0w2ppalIC/823y5iiVAFAUvN3VUbMLlMiuuMmkT+Od4XrokS4JEMxXLY2imT6JoyUFqFs22qk6nafYdFGlVh8HQ2/2pzlmR7WIXyuQ10RutethrE83oQkg2plXHDxYSWCYVQtx4s0lBJgJntveLjgybDRrtx6Fl6qZICELNj11frwl1JB6VfwlrTHe9sGNjHWsiLi6RSurtHuJqqLPaJ7IfddCC6ZIqQHb+SDimhdh7+MysBAPzK77nP9n6ii7RIZIxK6/P483z3YdKYr8pjgJeYr3rk//n0/OmsHdSy0MHB+DBQlwWCzGCIUOIEpZcrzPspVrkIc2R9ZlHWjscJqA1o9MVijXVzoauc/7fmP/dCi7sv8xd7TFAhEgnZBB+X+lrBWt3EcTMYoJOtrbW1lWG7dpEewEVWkyInXe4+P4P09oX1gNsan9r+8wXhAs8ELmTTpqmqWPehsilLz/JEGYHg11+6q8GM2d2yYlNRtw6JI3NVuL0pR71oya2uN7VN1sS85haSRGqOPo3JLSR3hxfJfDD1/Jp05VvjNiRc7iUh9lk+vKbgP84+1tHCOqWNqRAMW0p3Utkck35YdJtrsWn88ljcYPmNlxIi6x8GysQZ/IpQx+bWHuCEE0nZk66/VGN2xPaWwqdx8yusx8pyjxb19Xf4fmtD2OKe5Y403Y6cCaYaNwyKHosdGv6uQ33Nr+btc5U3wR3Tmlf1zRjamdYwZSZBHZOJk9K2Onp+6MUBnmtsltvAnqW3ptaLn0uTuvIEM+OF3PRorZKW5+Hw3kWhbd2vYhb5FT18ww6eubi4dcwnnmTq2NUNeGsVaKo+2mjXRHOU1pX+CYALKAhd+KGzoXkvKM9akNUAZxwQ/Iuy391KxamrJ7R93wnrk7QmR1zjyWzXIKeqBpQJYt8j9shT2hKaemymoTcTNDGjRKu9ypmlwE7JMijQxp5KarZZzlUUWJaJv/v3YXI36wqjNC2RmxZdtgmS3ab+gd8gnLVSFIFyb/f3OrbmClVNuvBLaB8dr6T0mwfL82o7ULJdCNP1+GYHXf/9wjMoW5cEMcF3TvIj405b8FRaQLsQ0oI/IhrCR5hUIMx4mQzPpFSKpvY+QvyLCBnBvO0fS3jDMMeYD8rK1FrLNpK5zuKsMGWF4Fm/eyW6qvhtarKO9b3iW2Ckl/wbYWCh1NWBGxjdF1Ff7yUaPHYMsCZtf5jGBYsIL/irrWQVFCc64b+Z+sL3tOBX7cVTkNg1t6DOTA7UpJyki5TXpuDZG1OQtlgW4glrWz6RcW/F30OKGl16BjMd/UoduVMNJhAFRSpvpRcRs3lEGXanj9SvhTi1Nsc9eQyYwJ4B/8vN26GfHUHG8+M/jsBlBH7SGnaqXPTjw6N8o15/hPWDgchjUjC80H3NxiZ2e8oxcpF85ZwPtq0WKXKZsyiYsbaMU7BCitteUWjcnoFtLjabV6nbqhKQqlbhMPf/Sqe8HR+Nv6dfiB7g41mNNjtyjM+pwby8Lx6i7wvxfLH2ZyNUExQkxYpGP9DWTniLIYhsdJqyKa8KdQ531zWQ6WRHb2kzoHbzZ55cY3d2AFxfGXKsNmvB0vNANiwhrhkqOeiTdORrfmKBztGrnvBNjYbksxHy/mXC+PRo6URljKpnoSOULqFpnqej8hlv9XKjzOsdGrjF26mqAi4267yR4zIKDv6DnC9hpw4qvVx7S3TpvrlocrNScK8iRcE5xiPE6kD7eCLkrpfL+JoLvlidfuz4RZYrKfA83pz5yfKKx3l/uylai8eRK5a1lT7BaSnBvTPngiqZvvbGsRYlS5Yjqlotpo/XZDfJz3q/iwqP1TEO4QSQ6HB0YkEVUdDFAHCGpMW4jEH44DGTJ6xFHUcLEjgmFgZAS24TOyInHr6SeqfICA85Ze2Q4zKTLsFlbOEKPvu3R+z22oEGCyKBHFywiFUAF5W5ZiIPCJI0GVNLIornqpV0kuXqxP+uyMKvxQCw6BWfHvmu1+r9RdLJZObcQ+83FUj8l6flb0KtqJzxwlm+Q+elw449+gYK/lRPz3N1L/J+xNOkVm8IS+/WCXlVkpgkhiEYyK2mzMRZIFi2WFLnmsoGcSuDV2z4hlkzJyi8BimUBYoX4y71PuNqKz28lFJhOzLnYF7KPpiw0ZRMdByNUvU73qfIdTXabyanJ1hYfmmfGJmRHypv5iiU3H7xVTV/R+7HhZUUTqxhrALrKYx+hy6NqXlRVyCP+I52LjXeMybkvDqGQ6AVdLkU9DeUE4mEnISVzfx26Ro7LkaxyBjaALGU5l9gafsySOPaLE2P0qTypIyuutjkO6GAEVkpE4z4K2paUj32w1KKQ0dJwM7b6Gdn8v/mHosrPV3SqYzmkZL04JYA3n+T4fjI8X6wNVSirFz8c9/sUI5o4/DhcgXQxzKAx81qMRBr2b7bqubmDHlkPm3Hk8APsQvq5VbUoqcMPdSwslD5Vz4LKfYnaueYwNK/XOVksP2fOVwNU36DIw4Qk7k+1l2R5udTxPGNdkY/w6w9ZxsOQyP/8essCujwdJMANQTERlUGZZtbDIWCWlLHMaVCihSUGLdzRL80am21BNDg9fwNfDIUe1zVPMZR62thETNjWx80TiZsFOC4/7v6+YR+LPhpIG2Zy0Du0XtiRIdu/7r8+NdQLXI8+o6ecthQuFCI+iHRiYIXiDSEg1uQd2uhQf64t5TFEwfGZLVRze5lZz/yQyNhPGzI5s6r/bBD2cfj2vVz9alm6ahCVq39l7Gn/njGV3o3bRNRZ0IBlJZidu1fkGb2rUdZ4FySba/L9ej3ylkIc9pVc4qNbtreKi+b+fBwDnQlCj0tPFfxDjIdQcR1xJquSFFkdFHLNVjcnt6RtcLOsczCOe/IkOeAhdRJ8zxTVxqiDXi0vR2tm4uB5aVmqxSUufZDxt8jI/bqgFwAQ4X2GqAsoAg2Yesp+dm9yMps3/STsq2b3GFqNAwv9jZ+O8GG8MKEO/H2Ip3EdJk4YBYxdhS9yA4MpnbNlFFPQTBN/rW53T6rYss6a3E27pbS3ORJ4uklO10Ma18kORJf8J9CHfdfFp38G+wKtZ84oFnV3Dh6VdS1gyo18kHKTMjyOUtB6buKC6suD/OTphZiqWy6X59JHmdyeRino+hU5tYy9C+TImvkYzCTdb+rL/2YHn+E4Xk/KAO5dWliGeWPjRSF5GP3jLsBYPyN5eClpZwk5iMBiKespHkfYRo3McJChZCBiWw29nUE17BMzX6mZa2X7ob3kXvIdIz1tpJz5KJF67ZkU/6wliHFMT0WeLSYc6wcQGw9gWpwA3mP9n6S4GlB5ihN5HZ5WbcZYmvMtJ1TP1LoURL50wC/B8Snfwsdclsywmmzu/LOzwmqkTHuis3D1J0QVFNQmbMWBZizGBguoflWVVfdpQJF0OAUc905Nuiq74FTbqaANQ2/YjjSwsceV1urO2LoSJ0JUho3quJFoEWVEvTrHSNODrrzSk1N7Kuxr5E+npyWr0YXvaro15l/Wr8rnx8flK3UdU8GTDqL/Ow7EVxla8hNMDZNe45P6OMO3wIAYfEVN17CKyqsxmOpW56BHkaLqRrjtpx+2zmH7/WZEulhWXEYj9Xi8R3fyrAAIpBySCrh+HHiX6jrlXUclvzgUvC20jF8VtvJ/vi4dfGglO7AULtoD4Znp2mgaztIjHIzKhduqDQRDZt3gXKO9o01nhzrYi+nq7xPJbWJLB0Apnq9yTJ/NrwRnY/bK53uvENulCI40QPLZdJX5yBcIFl+iTBXR1GG6KW9cDCBV0IQI5CRWXL2AZPYH9S0fFBn9hni/6aLs3LAe3zVvXpp75RE950mFV3e3hBYNgmiDjBCWXY/D4HD0x0QuCGlAoIK84YUmfjZmXryakrbBYVHOda0ZI5Pelc0Lpgi9PLcnrywYefRNy71ahZML/Qf4kdJFv0Bu+LUkQgBlM4UCVwKS8Cp6xk/adBY2GTUXWoZqNc+9I2QRbjc2gjlWyN1pcADoJ7xJ3IVIkkLiZOFgO4opiwodJqg0pzLNKDsyKMWqwvPDHg5F3ETI+WjZ9zYxxZj1fc+ooSKFoNX4e5I44diEismlPKY56g74zU/DWWZuSIvgXRC5kyI0+fmo37DVwl8uae5VrLocPS7NNJoOYxeae8aKzmMw5InuANmVm29GM8J9NNddQFK86jcK5lqq1SaZHmVQ09sTmh+JDSs3qluJHuZpgoLEovyAKypm33gJYqQSYdFXjWTyVDq9I2A4wH7G+01GsuG2XEb/c+lXcpExdH9Yvl1ixDWzEmyCMBbHEX/oil6DXfea55SxYk338Mq/JAsKcK7P+yWsnquBqvULq8533FaP3ezzuVUCYJcFE3ZW5camkumyMCOa51Nw0JbTxNFF4ypfeu1JuF+7LWIxNetGeUH2/8aFmBBIckLorgpGzOGWDZ/VkThltelWPlK4xjs4kevcssRMUKJFnVEUxVCuDLvS1B+QZL7LMR2oybD1cWLIsKwLgUsc/BP3zVUv4SowMF3zh6eOzWMm/4KiVAuT5X82ZRXTiNcPqdo/fb3XYIYViUvr4/mx5NKPCMFj31Adlr1AzgzNUTf8P3mxpnqHKK7gsSrBM5Z7mo1m9fsEt81fx3hHb9RXVsanOPkOylpBwbMU+yfMvlvGZ1XFDVSHkW4ha+03nkwCHRiqtZ/Gu5aI0guNfM0s4zEIw++MqHZJktCq3t+WO158hL3veEzkaeN95fGMoI47Sjir/oM2fYO3ZLG0o2DWhoE0YfkWjHoFei9UxIVS8lwymzC9n4JoYxHOEqMi8SEMCh7eJPJ2CNmIN8ofz0ynJcWTsfir9wXDTR4AVkoma9ilNW8H4K6bCAUERDAhoiuEP2uvhw7ojQYG1hMX/3qLIZmbgXys61o0qhIGCXCSey0/5umPRtbMIYiTX3JMv2CPD3vFZlehCh8vJA1zhbHdQmuCmpoUI1itduqJIk6sYF6h/kArqxyr5QVK/8UzjKQx2MDdZ7ijU317QaNY0Tj2dvPp8hBhGTvBHudP5hpbUFI/rkHHEklA1REM14tqnHx1C9Ebj3R3p2xNtRXm8QxcBV+2Wgwh6FgC4br6qgKT8Zo9t4AeSF1v32SPb1WKnqN+BKIb11rImuqM2bFV/WY6VsjFvGj65JW7sP2X5Vl5IRUJ621RaqtFtJb+sQ19rnJG0Q7cMT/BcezcG+mRLA9fB8Jog0S5CpxNmmQHOvChhlh09hiMMUbuio12U4gOJy5xZmuWaKaJpPzC1jCHLdaug9qc5fuBkfacVRm/vm0njC0ngrQtqPTlblupCrvm2Lgwm1qPhG3eouukDt8s9ztd68SZYCLkRIQ7rgrOK/O9AWwl/6OxkNu+pog/3VM6BggAvR1D1IcyKuVAeHgswchZl6E0bwn6YkFoQp1VYCVr0aXxR2+EEAFHHFxuY4/E8NVmCCkfneHJfTKauuLhQep9QFWxMyIJqHjRGuTIHu0JRzDL1ttSknTN+3PxW6XWTiUBXLQOvvf1SGFSEmXDF1b1R8cQkvJ8RvFEMmXAVrmrmEHJQRVUggL/zUlHIsWnPsjO2j1vr8Vg5MaE0GRsBkJ7nXP5pw1U8slLJGafazzGd8TqOx8CjQc9zFKNrq0J26FvTsBeE4QfqFsjpA0IrlQ3D8PDbPEbtc3vi6UIqndzQx2i6G3aVZh09QSWSqw02HB/i8hhDZ4a9G6X+pNY/ejtXJRkxHbz9CLI5EH4yHNgF0NO5EkHPok8OSSRjsPJ+35axBBXMbmJcKU/1VG89uz4jkqdYkTpidNIy1PAm2Cp9yFqn9xHaWCBSO0Obkx/sG0oEJ51hLCNZWty7rLv9qawMdOqpTKulyEqVSdBU7fXqUdkn1K5WJTysTa4UfRo3IhEZvhlnRYTC9aVIxT8UFSrHQPVR3YWVACUKr2iJGA7Lb+ybBwzqa9LImLMReR7CFyHg/QVr7XySNDcEtRGqNoIhTLsxD7LtdOtutBzePUBP/YDPylXvIXyjIFHtV+T9Smi71R8GUWE68+/QYW1NF5PY8ObOdSfOcTCkaQe474R4w2I52Ihlpo5VxrF80QDJXUBP2sRo97MXK+srcdKKYnr1xVfbE/iOvKRHmFe5agMA00DiQLbQRDY35Q5IKXCfhwwUiHRGJddvAhgx47ep7M13ZnE+FD8kQ7kGHwkaD3w2ON9IEOwoEk5k/jqtF8zKidLRnW6xV+TvNZ73wQhiA1O5Da+0UJ7cVXmoSqZPQqmVg4mToPvrOuhs+ZoNjjh5Aj/awkec0OnKTsT+WBsGbX2BpyUGw7ULRhP5I9L84c8d9vDrsRgifOh0Dn74UDOwDr1KTOvLi0rQ9JUU+efi0L1TVOommPlJET8vNBUPmw2KrTI9avFAegqRFdv3Ugw5uqC3ZZiZOEBxMCfCFWkFzt8eTfoHi3rNZGh3EVrbsUOGDkYnbvjDch42Wk1Z4pCmBDvZrBDuM/df2VBBGE7q47FRUI1rWM3ma5DySC4UG0GzljTf4cR1x4o9U98lHBmnkprNHaEkXK6kOQwev/v8drV9j7COEIigC6zw1/Pro1QsEuKKhrPWEJUXgTbr+uFT71BiynIu4vKDf4iMERm8pffX7fqBDR7CUOGjJzwUuexgaYoe7X4b9opImmysSp73QlO3KwtZlPl9lH4/mgq0kJSBDnyw2LwgUXY/UpAFUQAKcWKxx4s/ISnTE/UEYA1DCs8buzL/bXjZccyot8xN8WbodkpEm6ebTTpULhPO8GMlGHS+6LZ7mGdIYoz9C1APHNCTJ/P1mGJvQxckBQpmqs0+T91DcjnkMUAb2f7pGJ73/JM46QLSJqxuJFwtNrRou/FZF4+YMjrjwNGDrLRNJnnECxCFcUUXob2lBjQ09fJPfMiWmkgWbhBsIG2/6U8j1qW6agB5IwDX6xq8ra8gH1Faffa/Rbote3SoyauUbO5AJl05bGC0saS/SYLz9kQoOCeXhxQ1y+tc2Am501QrtUozJQx7tArWyxcFsB2hb/pXmKsa3bj4W5mpGKP0GmEKl4CGXby4bM7sQ12nq5PMjBRdgy2y19CAau5ch9/ssyNlaeJFvMys0hXHmsM1TY7nAxThClSBaaSE1gMIsv2caZX5su1ME1nCRuOizMOjgJusy51sYifG0KOBeKG3BaCFt1QGfNteZGlntkQ/bnvpNk7pcI0UmhEvmCbHD8Xfdu2zB/bqO3WOwBMoSorf0np6ntpQPjFgQZgkVJKbXzYRf6YvBb90+Vx7Kvy0+OzeYSxZ/qFBQWT6wvxOdeYLs+afXdkZGCdvAr0c7R9eze6wTFPoDKCYhFISdjqdSVmqjK97rXM/bpBnVLw7mkZEVa+/LmdMCaCnBevp6l5dRhuy2oWQjQWs5pc8jFjHXr6XhjN27bhKNsu+j8C8CRgNqX8J2C2IOKnWH/VB/StQf+i1JVjJ//4UCoY6C1yLHddi6aUo8Wiak94MFrtBZdHqId5oDN1Nk+8+Xkzpk21Lv84flRt2X1M0kEw9G1HUcFXQnquh6CaG/iTpicrDwtRAgGpXpuwjK71ixplg8LbVU1dkCHizbKAYYCqVI25kK/d9vkVUohP76G6yf2SlePFKzdKUSsEuFZN9N+PgpVWxmvbtIAQC4wxG9TBiKJxEwYmH/IBpFzXuB5+s9bzgFqnCiJtRNIKT1VYkbf7ZCH1ZrJg79R+hfwZdJNUiEjVkYdpadsAeKdKlLyeMNNIku0xhPLypk6SpxVX0heutkwDCLcH1FntqA/FIychinVYx3vXejZ44xDDwBkVbQQct8LLadB7KflElfa37ogWmMz94ws6tMlK8I0k34UK9u/ziodMHCiH+IqFKCstsDL1gBLTcSmMqDCqqcyAaX4oNKKBZtt3peFqVTK3dTk/JqeGXegJc2Kd69yST0k4atDPrprkQN1Dm1uFHcUKE8CBkT1vxTJqXKDA4+vgtfM/mls67f0qOvyR6QBK3TlT5gExz2NbvXOO+m/KrLTqrngASESDkUASHZirC87EUgD2eSXMpym/3h2Pb2FX8+7HZRkIie1jshLs54XHSbB7klSsCEI8qv33JhbNcLGQq8OLZpOe75PH5wz0ngc+XzT1U8qBsHuiR5F9G19v4HgdXY21GtJkirUKQekWBp/TXn/vtdcp9NYHnrAmj+Gxm0g9F9VEhT4LcCD23uqDtyAqLlbUerKlEcLLASg43cW8ZOt9yQNd9sVakiQ6S5rP5nm5pS7kwTFLDpe0nzaAd5ku+9pvgevPm8urRd/ffW4REtD/bLSNJUhiX6BRqkJARRBDnrD96ZcwpkRGwFtugCl6p5NN8k9Oxkhe0U4SF7h/dTUwY4WgiftuzIVIWN5RH8omWKPdrmfaKdzIq1zJS1xUmZ80elPImqrgiwJvaapqEfxvjOBY8Ikhm0ebdSfjkkeurZQaig2ylWbJWfS2tbgreFtrPcbGGVv3uk2Jq+5TqsGVtOGP008YC32ibEd1BYCumv9MzNnPGZWoMcyfGWMIJXKCdKu3VYzBDiDOOsQFZ57qwoWZ1BZNdBa48r9FqMMeXqC5AOdXpBaiq0gtqEVZ09tLx1hYRfLxa0WwLGacFp9VqORV5D05vUAqLJFDmGQL1hEjrZZTLE17S9X32F0y5hm9A/286Btpn7vWPgaZOCmPvSoJPLZJyLYmIG9bAJh88bG8VcMWJRYAiXSb9jAvqTr4QxianXy3FSD8t2AYN6l4uMgtIy5N7zsSkgqbzrFzdGGRqNBoKK3KbVpUvT/71NxmofJVO3wOtWrQBhQ0/1CtsgN9kwUw4LCMSVTKn5krxfv/Dp3cq45EnodWDH2HbxgHhFdK6qsD50ZCJ7eyHGCXDQ3X48TDjBHt7yyTL+p+i5fz9TQen+LPBbo2xDU9iodoDnW861h0MsGwrO/kwPDzwYCnZv5kVe0kTj0+Biy1xMGbBGbTOwN0OrrIWJca2/54sNZ5kuzZy+TRryQLkfWSR6xKTPC5aKdJVGQBC68lBd3yE0hLDrE6+oOhjdqTBEdRoecBqnV9ceZ8wOaYjgPfw6aT6toxQuP2EuLl2jBpLajzN/w7kViaRBFqPieFc3UiMQ4ZJe4Wy6DZeGhQcSvmOid3NGsLTAMRglG+TUXxXAGazhb8OJ2SVrIrKAxurVvSdBOmfYYRWY4iLSDlYDFYyB/tnSRL0kfrjfvTcONcKjZFgu3rqx0vKLaTDo6RkccxhFwNYcjHUMGFVsZE3N/8KlbGpeUB8OSCVUr3ZwR1oXvks1VwDmGxrZKt3QTLR69SFCWZ2rDITz60QufYlLasKYY/nvd7U+GhgRf4ZJ9WZNRde4cvFelVanjvFAmbjjDgXmrSfm/O6/OQvqO3gADBYA6XmARcY0qcKWgF/NITczuVoE6laYcnnlTtULWkQhidcdSfeFWrTao9RCMxchlgSfz920mbP6JutrAC3/41jzRVZZJbhakLvD2ugWNmSJPDD5gncVbxJzDE3obl0hkz7Dbtg6R5ycU1Y/ag+/6lMEBMZ7X/UiNWZZDWBNqzsfiP5KUyEvcWj8BxbiK4jYa8hvAZNxwXPrIW9lNGZWL7GpGoimw4OG4mhOtJlS64BtfsuclVa8JjHaKiEGBJWW8SxTGrZdVwNb9F1yGjaHSIL2iaUKuZBUmP1Sj519CBfiKlKZilSaLdyrWJ8/4r/aF2dEh2cESllpwJVkoRLyxMHCdhCObspazJNXBu3bXIinLZotbDuYZIPmNLFC/tcK75q1g4Q1YsloG7BkSRcbaKA+uzJ3q3YR1dvK30uud0TOdoc/jqGoM9PBRovIhpsfgFp9zGD1+FxWc4DdIUusThX0yTJEbRPjIj2B7gS8MOidaJtRp7coStVVOtKsegyox+4RkoyELuI8B+gnyPnVQLnTtKPjhyEMdNn8bmmlVOAIronh8uVml7h9KUtKkP6Y7CFrY+qFovp/RSuA07kINtaB00uo26QRCWKm5lJef7SzMovV84NH/EcCK+gKawQRA2cpDGUCAZJOtDRZBHcECpysMTEn+JYaEPSkrTiXYj2xt2nURB7P1Xm1mMunvafDD0bOOiodzGUtTM/gaCaaxuKiD4e69lv/bGw0nt1mhoeLAkMpE43e55QvmHDDk/PqF5YgFXghwS0ebdtP7MuVChv/tyDoTeuW+WnJoft8uTNL7wzV+4W5SUKo+yin1zYjbDuivzVXUhAglt8+FHu5oNG9LYBnF/VM//XVI/q+DF0j4WsGoAbVUPm9xmd4hC44F0KYjVHzR2DAEioaAof3/UrNRNp3hWBvnHIiBgPdklM4s1crDbpn+uIyD/trjM4FfINW8ajpwm1JGbkbKWmp1w9hM+NsiQcAKXyd+onrpp4VcoutYdnAJYyan2WG/37EEWTowkGKyHNmWF3zi3V5XxqHQYfmLqoCfQYa5Mh8ktphGzpyKIvm3rZWu4fmt7AELoNdvGTy8R4EU2F+tX4ODE+HK8Vw7UImtXrnrNny3RqsitgVkv9twaCOXe5WWbO9Lia154HsjjOz6OAMpTrIZyiX7A6gpfmXkmvzi4sdwm9xc741Nlr3A38nnrO7uCFq/8k4SubwaFczTMgOEiGwob/e+rAHOhmWiDbIyv3T8JSi8Ep+liPqGVXnKjjGY5x2x1W1TYbapO8tnfcGs4CaC0a0HKZZHv9VDKLOiZYVORLvoA/oHb7WDDYw7oBopGDVQVRXg6gyyq5dNJ9IgWoA3M137AjIHM85Cu3/dnzftHbZ9XEqtI4AvH0VsOuqkkU0PEZzC4XBDG/mRbRqJ4nc2x21Rt1nolkNTaRX6rQ4bXB6kb2g384P5ycQIzyoSmqLqYCrTtQCZJXrIuPFljsC1kolh40v+OyjdEYW4nZc7A6YSc/yFWJM4VY5uS/5vDaAZs5Ey/R5rBs4/Y5/T6zwAHNJMGLKeaOvcjvqXllZSiGxj57QjxWJ5742+ojzGpdc6wBUsm/Z3U9j01Qmr62U3YYOtNw3aLKzlLA5r61Nhb+nW3VjZXF8M03NM+RIck5n+wmHrgYdUXVasMZlgFaURFfcbDttWgo8JM0pg8jgHUBkl9iiZYIfHPmL1vA4B2s3LhMFj2lFRVx5PGojVLAe1TpAb9Fr6RD/MgNK+6xkHGQK1ZdwFqubym3PK0iduaxQEn0roTyxD4zQ9OIp5S/FphWSsQcV1oTGQhm6MRAaf3sqpkL9DBgo6uEhNgSQ6mCgRhmYx7ECSfaTn4cwHXXhyDz0kahGqNWtA9hYsEUg1bGGS137pvozv3JvL5V3kWDiblSKgSPeVe58+uukeo43b2aIq/mUa0Xi1EfJmr2JIjpXA/r8oTLEtnAsbsw8vftxdvGjC32akR8QpTjucEja4C3n6Dl4SnpnFInBcgX2Cl2merg3rlpejsHnNQv0ChbtBfCcsJ6zZ/M5Yb9F5hiT+TA5PtdJLLwl97Iz+Tpj/wztJRtAFiPFenzzmZ+QJY+cH5t3Y4MeyIMzTrv7F+dDfVtnqMwp1GOTJYSwyQyU+RVb6exMfADQtNE5SpI7+MRNskdQyIC7wFlIQuxnIzNByNoJqrayC6XLmN9nYsvQLrRz1lGroX+PZlqizEZMvefbOkeUhVsyBK7fwNYrelCHNQgyIzpe6HV8yBwVS4jxy5frmY9JVWILrCKS+FMwhRaeIZQzpZfumy/+nijn8uO1T7kNJi9SLMxU8M1w5q/W7tlNBWyKR0bQo0e0/d1kx8WoD603tjq6+z7RiFAlvpSavYyGljk7NVyv2o1tat+tSv4N/tH/MecRjr8TQDNJQJfxw8bDeTwawLgfvmhJJ4wVXB7cHZ5FZYkS4Z9coVRVCPXdiNzPUkNI0WfP6btNne2Ot+7RCWOsN3qNpNZSrOIrDOjWxNdA7n5YavW/zJZeZ3hmevg7jYrQv2vGFcIkL5vgc0cGoZulAAyFcOGk6SQwyPpuDU7NkHTOCEQo0SIlUq9ZOX3oJLtDkO62aXlHY38uyXHL1Czr/VsMmxYOxz+XQCHRJsb7Q/3zbabx4bRemcIc3+rZSKYZbGXCJ9YsNms1flRDnU95Ya7ZB6aw4AnuUg1lhdpTWlb3n1F6s1RZK8ESCOrXL4nL2nuuKaPrLmRjxJzZoldj6XAfEWDnupEKdckRRcUtePwvTosRmWFIkXYGS4piH6LlJu5AdFRo4GbDkvzL9RT2S0YjcJ0uXKzJ/RvIObXJ6Ap1bQ7n9bQXFgVmAf29TqYDUDkv74dALjTE5teS2JTfpZqBDJjjYmvWtDcerQ5v5hHiT0dkJwq3BoVFUjjup2jchFuydceO7p43VYTr5RF0elnMYLcwp5L+123nnCuLyCZM/6NM3xWBDVDboqYHTOwTATyh2klMcUWTAzXX97DCnqAh2C/3WwjU/Jhrh7yAnH4+nGuWRMKgHKgX4I9b1C8zMGowh4vsWkbPhMmFj/loRxEYe7mTmTnb7EEFY3z2tOHbRRXzujPI7aCbe8U6gXMz75tQZNN4jSEAHh9NOISKBt4IWAVxzGlKzHK0GiWtyr6qv49ejN0cqwbmdu74B2PJDN2cnNCZx0rg12D4WhNYd0IRrpwlYUUT7oZcLs0/nScu0rWbvyKrT6RBMgAHP0YgKheJ/ldHTQK4qk6nRi00Ng6jxGT7hEpzvAINOI2xfNiv4A5TymffThHgTjT01qVbC0chz4wx4oGp7PRkDCl+fLhC5ZvpS5xdUSM2oKrX8fph2VaNBxAEcxBSxywV+zc5Gj09SegMChGC5RTO5I3a1OWqgQnYOpATZnPMU9HNF0wuZmJMYs1N0Zh91UhUqNJQTrdhbZC6X76gLHCkbuVqO9T5tOngYWBeb18RJHfqggG4trk+5ouh0bKA+ja63z9Wcd9tFBs8BUKpf3XaCp9eH90D8AGVloZuZe0+iFnwDSqUGrvuaDU+VjWa7CBJYzVm8dCfxJsJr8Q8L4k9D6GWBsJpguKH91W01uJ2VgLip7GA1v+NF7DnRvopCPlfEB8LJ7DBnO1Z/IsEDxaVOvFlX0C03rEdAEjPae0cx/5+Ht6VNjonubZVXDO3n59rK8giQuqsz5GFHB/xaMmGhWKx0E7uk5copAAMJqW10fR27sG2yXZes8NE/xxy0R+sy8xhE8ZkHVjtka2GAlghfpLitJOF9W+vZyo9eB6mGcT/u/339o/DxPE8MyQZF62r1KYhbhOcxkjbu0y5wLOKFhdWrsiPKNvXUfNsP36b1lYw8SLlEJmgmXAyL7UnkAEl3UFeeRMgZyCoDvIkIC3nE57BU0VALFO5gmBYI/Y9MY/OiDEWCVkMEUQU6Pnyt8Jg79aV2agczQ2NB1oAphKQCskG1BxJajEzp/doYIpGP/5Vbvuj1XPcTGsyz26nJd3NjW0jcqSJ6QblWvNZQKf9hxwYW76y5MvYYbz6P/1cZwZrMpgAHHge9zWzx3tQxOqimgJ+43WLrz8ax36vQ/wlBGSYz2VF3yUEd6PGSCRVnOAp8nQ0DfXhZI9ShqbcnJJu6t9LYyiKR0q2WYJLDQuvUr/hlbG7iuaAJZ+jNh20jks6Rc3ECOzDXZvqYOJQJFmcjCv9rcWOgHLnZaRKU7N9VPYwhwa77xUIWStqin1xylcC8M4uBgymvMrwN0cmrUwE7amrLUZgENwBGVufCW7mThX28anc/7FqXl0b7gjYHDHTPla6MMh4fDx5yRzWbHMa2cEtD0lAg0709APuZcM9DzLejsIgCfpX1pvfqIBJz3tpSLqZXD3RZ5mS/Geh+mdGpAAtDyYxG6Qq86uQWsA+D1bBTFz6jG6Kp5JNUODjBtnlYTqnOg19Q+kAMs86anzUNCspmPb8/d05sILFiU/KUxm/8awUMHwAkGrx8hekeEYsiLCrFgzXHN5LY650p+32GuJEgzl4qsrVpHJIwXDlKN1GsVpJC7RKjtw4euRSjj50OdPy7EDAZPZB9IUvvjEzmthwN3AGDGkEpOQtVeoTr+5H8X4DZfyYOS61I3f8sgmPx+HhO78RIsyyY9Mkz3DQlb4yvuQDxNANpjxvU+t/eRItZ0D59IMEzsHp/lVTiK4CVAomEJvEMxE3M+IoF3BLaaBxbddb91Bn2wO8QRwMS4hzEPqH5YVLGkwPFuFkHN+/O9lYFDRNoI27id90js/MHtHbczuIYGsu9RV/Gz3uZf/mmbHkduoZOsem5y8IDRfGJD9VTOimBww6F0mJcgpyx5NqUFTG34rMyhIwB+BLp4dT9GrH6OsdZ60JUfWGCzSbpPSpLNTQ6va8IbaDmBRJXMXhK5m8YUN6oPVkdYKwlA2MEB//AP0C3pgV+S5mkh9ngFhzg9RpijwSO8HVhl67tpsd8bxeyk4W7Uxi4dEwC7K43xUZVu7TeTPupuol3ctdrTL+B3nNsPEu+L0oYzTFO96uBdaqywOy+4BuimqkfWgtt4r035/hSfRkqp2VgLjbzAVA+zmragnGnGA3ggLRUg17fzBsmNwM3WzoQXdhmQN4wMfrKWSsVF8nVqL4UVRBr698uhcnbr/Q6wu+9R3ql78EdCk3c85yUuxNu5l/AIgrE9/BrFnAnBCqH1j3YRUDUnTILIbYr3k8NUYA1rc8K3k9R6Tt26x/QsP+qlTl/dNbINCz1vQcroyyxDIVCyZ0b4oc0gf6wXAkgjhiNLZ1iz9tr/+PsMq/WD/JY4qDhWVK5nPHNmOw178MXacW4e5DkH1da0r8GDHCbYMwpDZmMTBm2dQqKCooEs/qqgM3bTAYI0nMghZnhrQEeV2KANfuZ5KG+DdDqmUmTvDzhWCzOMssAOH0DTZQnU2AEOpdTCA29IrRUxPdIM1CtfTDWSmo+Rkc/HOObwv6ZutHcyqZ9fle9Kl5DesExUmFMxdD234D903x3zxRVAwTLJ+1gE+aAQXs8s98xm2kmKwOsKmHNDhX25tJyfzcaU7LjAPQO/GcxtPsvqP9MCsh4sX/lUqRvbrhbnChwPWZrXjINLT0QPlbHt7ykx6HKS+E7XPEh9nlbrMjFXKw6m32Ne24H11pV3hXrc30RiLdldyQ5ENSQVQgLYqUkzH8b+9G35FG4j1oO5+c43JIo2Qg/oMyY5SyG7/9QBtAg7kiZGG5ZzLKshCW+pdGYTGombPERBJjweROY1iMpxbC3hR5JEo2DzMkPRoyV/mrSMi/aHL45l8oBue6zq+D4yS05v326Yitof92WA9x1t2KW5M1DKrCrA9DQni2p6/rK1ipbgIa1fxbfPFpuzVjlTJwUg6vrXSwIiaScr+2lQsny0y8CjcyADp6pNYNJlhejNXWumF67o2U1jurSL6Ssd+FQGyTVBcaXxRCiec+MhHHEonexdGAa8tXwp6OOTyGXgbT7hx8GDXDfz0CZElBq7VuYigS5IUAOmKuAp+5BDvQtkphOUmxR9qzd67ldVTAP/FNj5f+z3MfB7muNiyux63DX8FRIBICfEsrhsG5UrTCruGyuheAQW9FAXHIMPcVh1FgvVp3KHL6L8mn6s5S27U2JahiY8nWMptLhUyU5b3KSMOIIou0trJSJ437i3lz5KTF5wqcfDLx8uX0S0hfQMIrXaGtotKX8KCflQKLUJEhDO5qauTOWP7loqICVyVCCS8FykkQN7lnKuBB2+JLDNWsLO9K4fUjvYGGGerGiVoCoQsAxpYK3b/6v2pm1vYlWzOCJWHYn8oRfuVPvhWCbnBMjV3EdyJZ5FIWWwnpPW7/4pJdT6hymf+C4H1FxIFBpfWYmVdlU/FVCME+vmVQyDBHCBW0hxnS+YBatuoAD7Os99I0O4o6anaPVgfFnFpBiC0BX3PQmk18xp8PCck4fwMqOFg69iJTf2y6SRG/PB1AmigIJMZ3Kcg5+FOhD8sKoJBKlRnM31gXtbvyWQ7esTTVg0mL6LulPn2ZCql5hlYuZXEVuIxiTPnibr/8ZdEfEANaZ2MJMUL8cmoc3SbhR3AsmLKaUbRwVDy9IK/6GJugEUYqevuVkMbsTVYhcivwz+HYf8ZdRVK1F+zQZyyCT7zVnyqBSiIeV3Sk1LN2NH6j3oWM1VjTNjrGGCyJdeMdBSG9KGtgcEZWWtR2UyG/CYQv1rAq8c+GN3ngAYNlFuWsFDuycl1BkksDwD063qcU08biLQDNrOuekbCmwxSuvWhFcai/FHDQVkia0kS4F6qJYqA6zUidek+JEjQkAkWC5a2ES+dFqulA+MpQxxe3jDc6wlxE0iwX5bRJ1TZ58Jkn0dXz9JoF2xHe2bETKI0G68q9eROtGGtwQe2RvcR3SXWDNyBB4Q0YBvZpBs0PlzAkWJ6P4JF9xPk1g0FZVKeaBkyobr+to5AUJZJO9lK+EO+4RV6/JpR6MuvFjpFKI/lssHkLIKU6uNJlvXF+24hqXhwyZWqcrjEbtni/5zBXmrEBhMIIgW4nc1AOt4PybMrq3AIC56bnLItSWnXrlM0s+vL8PpPLTbGRVniE43ww5OXOMhH87X/BnjzMiVRiYkO/WGzngq63RFdtk4N2ruKyHaW14uXClPRzfefpW6+TD4c74B/yFvVCkNvUbtOwUPmAnkEAqAIMNPFQDVEQxYcQheEEn5R42z1j6PJ8rNGvG3cT2+lVNr7rZ/sQrx0m/Jd5mUg3r/8IGefKkknf6wgQ+pjYUwXmUTf6i7yKmhoNIyIXsi4FrhmVVs0Nm2kSkfT+CIOWXFc170ODUQzUNB2tBPAiSXuQZs4Ghbf+JNStldw/uqGfuKgjXnoqmowTQwwBbHovlOwbpOjIRcoN1YzuarBXwq2mFHdnGYNVRYXbSFNh3oq3ofp32NjLyDcjGe45cimyc6YZL53UgQw+5+dzWPSJK/w42OJ07Ha6ubUS4xyXSwxVmx0HXAf6DxpCLD1BdAf+rTaw8+UAdcJihRAF0cKDz2GNKwnF1XEqwwHhCgTPPfumJ9xQ7nBATVU7TVYpH8pHHXXzeoOx7nQZV2AI2UbtvZNcbnyAQNHxcCvowAn34S46KOkyiitGuzVQ/NuBGNzKwJg+2qKg64ekNwUJn/3LUhoFP/oesoigoRGdXu8SYEA53ulo8+xwrzJA1UYpIW9k8El7QjbQJS/6yZR9tq9WaLFZ4CprNkf8eEwnsb41NHDQRDwup4JyMZEzv5wbIzDJ7y30gR85GQF2r0qjYNRUyyPc8lkKORkP3/xsCSyNOGOByvnn/u5jIMgOAlfc1bgpCvGKDDXOXvMVxKAv/OSfpyyMvj2Ou+dcd5NvpmZ0wERNfX2T+ApktAHGYm/fnOj30JS4zXjzDAoj8P7KoSAer81rsSSrCkGtdGTNgRvYXPcO2WbEMDNVt2aY71v20PAwOFsTaXb283LzrH6Lbw+KGCEyM3gowhwRQAUfPOdcxj3s/BNQoU2zrcm0pFFyEgKwx12Eb1t/mcAT9rt9/4Kcw6R1T09Mku/c1Ksivh5BOt7lPVCuzWT0ATkmN/rqM6AUnPA8tTP86x8PeIFBG/f4dDfzequQvrr212ku/D6eY1Zwfj9pyCZN04jSAAYCSk5OEaIWUfj0Hbw4RADPPt7dfTInDUPEb3s0BU/UfOG5JchgVOgsgRjEZVO2ws/uGdqO/b/WfgZdpgEiMzqhCsytiRC6Ml4Yt1EsT+tkDLeQXHX6dAxCfAdTKjCsgcqHdanlULgvDalpTED6nUc8U8JmX5WyI0dzcSJkKL745C6jWsvEGJ/l0wB/WwPxZxOV11GsjMb2QkxYUEqqKbBBW/94B5KxNr/lKKVtERswMWKtD4MlVEgO+jEZI3xD3K/GGQyKQ3ZBX5UYPab1tRVxMd4TCPlvBK3sDTJ92Lk6DV+GilNENVIR7GBp6x8Vorg+NlasifMR49Z9SlzGgDUZ1bMh2YvczMbbx1C7+p9i75CALGfeKIWI2obgSxWWqMitwrU2CPRkjDflp94CTFn4em6PJaKyd8pFCIKv/3cOQsDI/H/Xxar0L0lvCziafxdR320IhBKZCj1ZZNUWMI+f6JQAANw2Qzqpz2xO/TPbBkRcDX5W9GuiR7ibRq7yXRW3QhJA5nFHfSpFYRjx/rlpqI/rO9oEIB6L8wgWMdaK/hGZFEJZO+Z4VRY84etEV3kLk6sCZOttPpMhmzcN64DuulMiceFBXy/PaH+1x2dgYMHFYxF8h55N10XkQWBCLPWNHudoDGebJwyyUOoqmpvM5Py6YDH2e8lXhicAm2wjylqonyGxLzWq83Ehnlv6JEf2wJOA/m6xSNycXbIlmxGLM6ABYc2Xlg44sOLf0iPnXivIYSpFHXjJt8O61219Xo2EAIk9qi2oB+whb3peZ69BYNDgkyXX93x1Pmot0bq4Bc2zHuH4QRO3ppTCr3aV+q7YJ6THd8AAAFWhZAMb1919pkw1rFgvbJb1uXU6KeWhSoPmgalZOeW3fsf7UXfW3CLGhjqyOKUX1JZGFIjUZHOmO2bTF9dHavLdnj2ZDoQdDLrkSZp3e+mRDFg5CrNxozHifblH3F5kYLnxZquunnXDVG4+0zr7cnMpWa97EMDw5XD1A2WLrx8Vk2/HRL/+pcJbngNWvX5ZnOtpGoh/BcgKYt9BLD+BKmWHlzHxM5tmUJ/8ytZOXO/fHMAegUhI06AtNpBNbUkzQBp3gl2Ag3Eak5GVClBdXw2zai1MUAZRLc1ttCDn4sAtwq+giFgOho7YWglk1PHKEapAbzacdyIp3CB82zbFhlzmv86Fe8IWSzKJdUZQRxMsVP0LHMuytwSJp0V3twD3yQnhuvoHvHx9etCZhifQBsKueGMpwxAqi8U7NN3zxV1p7AgL9D9LBvbzvWy5zaEDrjviwwU3rTXRWLcrKc7thBOqfNyGso5c1tnanMYZX1L77/W8x59dusffWA399YXTBVqJym87C/vN+BWL6vMxtoFsq58IDXWK+HUmNWYFRCAsrQS9tlWiyZsvuT9fb6eaN7+gks8qlEIjb8owbF0pZZRHVq747r4iMnfKH71MWpZ24y9Kt2crw8V3EoJas0zrRqVQKEIUtVd7sY7vvpM/8e2Rb+wi96oTQnwq5CAFfq6JdDCsZ0Ke5KkQVc9qE1cRIK8Pkj64vJA9PTcO6SmUgXQXVse9M0xr+owpxlwmJ0PDspp3EfKxnoJuKlJgffIL+74UmcziSoR3DQNgyYgPdLxlcpGH2w80B8RzS0cEMF1Ev+yQSEf2iYl8IWnK5jpfG8IoUvdO0Yi7J0654WUlSIIQLLLfQx7g8T+o18/xM3kpIFbDkvpyNGHvDOyJjCew+z6ve6WPD59F9N02+Zl0wUnVt8wG6hVLt+OjC0p0FGdTIbbSLTjqUOPsUf+LYiFjtcC7Thu6KSGwUCCsZep/4/8HETsto3zjP1w0ZdPmLYhS9ZHOBZq7bkJmW7V6Q7f6gClIzRoUSQJ2ja25ZCDfK18Llxzp2IFYZjCTaQC3Fv4OFLXfzzAEh3DmO39HBcI/0vZ67/pG92c5HNq+V8GZlnSVL9QlGBD5rREh087mVJmm8z1sgaAp5uY4Bty0pWluSOaMtBqpuYJsx/Litvlt2qn+QJacWkxJbLKbiJkUUy7IHmbt5QVmNNeguIgjGvWme0QP2NHJzepPlSHUFB0Lq02k9OJHvO+Ygrv2VMyqlGEf3VuzI7pEZfZGbqrtn7GnG7RsiIzhLLKSt0u/5kLveZ3ebydTM91AS3kzODEd8L2xsL8tV555fRULUDshCF5hu9/KNmiUuePpWWldm7tatxyyUdac5ktgvpemsn4Z2g0iRHTZj1gSr+ifNCRkQrlttIgpc/Rq1mnWTq2+4x2F7DC14QLRM4dqcgUgVoESoF2O6H59ZlNOFZ+AwNusNO209Ao6QLMLCncvtEPmmpdhSom50+3bUezjChjqwVXQwruaJQhHm26Vl4OaurL0yMGktryDsWbGSOMuvbgREIMjorNX13+EaQLDT9DRxcEyQ2dPFUv8Kx8nyhRNN25wBDd9UnN/j1fecAEZDdvWAfDd3/OIPM117jx/ZwfldgSNMCDprJrYROQKRqndU9QKXBfpQV/qjjjziux5ikx1rBMMmJpoSDHONcPghReEmIWnjR98/dWPXFespwtEdngutV3M0XOnRbsH80nnagUEHLZC7voD0PepS1OoeiNyKPzSanI0Zqa7vnzgRIWb7CgF68qKy+WzNNoPRwssmtSmpevZAUwkTVn+/fdLRG3ZuOTvrLIkoBpVJUiEfYzqpjvWVxUxNKG4Z5Xu5pWk5We6ZH0ueh4dMWwAqnn6pp+9uKyZ9mYuGq+CmtaJqdnVTOxjBLj3XLtwhBIxZ0b/t9PKEBUt3izRKY71usz4OTRwsMQTXTRBhdTeqidNV+6+f981ACZ55s0Y1EUcB6edvrqsuY/JFh5g0sl5wU9ELJ8P6eHBRs8uyHSK7Mwxuz0EjkhRVuVPL8ntSF76lYBV3D5+2X2bY/lEU/VdjpniUbiMv9kaH+vNfZOY27FK69Y5MSZYcc741xR84LXcf2T9QTFJc1anh9uZUCK1UylmQAqgwNPmK6ZlrF7OsngJIpt3hRHf6XPKHMjOuMZG4/+zJ3gMf86v2cq8dBQv3zzrj5POmpbx8TVIWvHrWPqGszeph4OcguDW3BvxLFAttKXNxb73fVxodOLM7qU6ZSUUeOWN9CPDZ3tuZAaS3J8ubUAz7yIgwEPUwXKmjBFD8WvzbEVazcu5EG3TSOs9MIM4InoMmCR1/3aSmyDQZeilMnEiX4MKguTqy18tRcCqjAlMxbUP9rH5JpJPoSTlNUkkdF/XxVFrCuK8bR418CDZOLgiyXVYElLUgQRvmcu0PgSM0BUMEQmUw5FqcqeDHwrHyu9ozRZMReuhc+XLiqk3wPrFAXM4buJ/1t8w3hD3+GuHZLoOTYevvTVCX1YP/NVWHpDZ69hqcxjsN711sXJ9G1r0yQWHi4C3OtdOC6VlU7AYr3ipQFBGtBOZw5DU/tSxRADXRooL3u+clOVQRTgPjlQoejx4H00614utLQpQT69nZd+HrfYAJPUywZITMmOicj7+W3RLV059rCSiS6Bf+XurYecxYCzOobkMaIKmp/cNc+Y103QVNjbM3Bxzb0iQXjYK4BseuOYKIQ6CFJkTFT5H6qKDFLTyKPkRQ4srZWwVxpfGnzRNnFdzWmiA60aR0Saqpb9f15HSzFshi7B2xTByla/vfcpGkknfvqShjHVOJxM7YUIFsq0WqV4ewt8i3kxgp/QbLz1VVV4WKlvoEjzBrG4xdvxnokn0xOMhZRTNi4Ef71a/ZIWqAMNFLcM8AycWescJ0pCt2xCm/nSEijnTMSYB0Bsin5A/Zzo9lZD1B4atilzxgae3j3QdSQ8AK0kdP0r/Vj+OxtlaTqp4ojDYOR4EKECfqFi7EUOQgKbaZoG8OSvazccb5rFuWqD6JSJ9GETvkxZhg6/CdjC9OTi6b1vVjR8ergI4VCvyUPd13qUUDCOv+2JEJpOo9eth/iswqahfua23z0lTjDLhjoGNy6O5l3rNSGETtDCwr6aXPoIWfxcih9ljeJoryBjAfDTrq76mFlJabGBgBL/GSyPwKXsxy70HavXeKy8REOVa9RzDfSKM+W/PKkVuY8A64naUVO6vVcfUA8KAzAJDXc+YgoENIxoU3L8fcP3+HBqheuLbMkIX1prCwHsAxDytrMbEW1mAimfk/j5EvXl5lNAArTURDFqtWIsV0RZ97empleT5EkQjx/jmXUXXPDDu1f6+Fj54ah/lsBkRsRUXXFBjmiwBJ/kVrzQgxkl79PChvHkltKtDWa9+uiBC+tUZQfaU0lesA4TPLlxkQmisld+cDc/2DsAZmwKvOwBOSaGllWfPc/6kpaqXPcG1Y8AKVPyOyw2w60CIRH+eB0+O2PgOoCcl2cA38OS2Puk7TT0iaATE8+e4lQFG2oH/9xyl3SmtLbqKripf4ATDYK+gnbnIzBJ/pv20GHfguf9q2M8sT3Ql15E7ePrFUEsfv7Bx4SW4MeVsBiHAdl8Rd74BL+bK/ClihrGpXRhWm53oW1MDQ+H/hOEgHgswsWn4mG3nnMfM5kz7K+EZUnZt4jVYECHO0uu95Ayvb06MLALbml0BX1jAbUb+hE1btJqF0zE0JX38gCkQLJZv7L7iE+BWtN9377/npt/WaKy70VeKU1dxwUdpU6r4TL1LEhaVsp29aJYAmK/ILsauRncjZcnDqarw5BDQL/8+HEqqtaegGA5gr4ThxuI2Jlz2KniUVFnQTIPDyFE6qi8/xRq5z2GZ7Gzv4zqlt07ATbRhCqXZZQdzqdC6lTVuZ248ZYJGAdODik05zykTp1ZO9obnU9Ot6IKTNIfPv/Gl5FO7kOhlwD7/vfjbiZDKcjzO2/gU9CzWrL7+jkoAFMHggu6KO/bsOnOB0kqOeqRgT8fgRtPbrPBNwOcilfoQ705Zy6sMaGEVzQDlbKN/X51c+vU7YTfsMqqaGExtsdQCR8dCT0B1i86L3KJFTc/qpWmYGVF3QycQb76VTtO3V68U9Wc9hhUTbEVisW7kijxQN9Ny2jCBtQkKSL3RpF4cbBWxytpJ52ClqAoNGC/GIt9ZQyH/HEacUKZbXpvhpUjq7AMSQgynvZKZA1JH7pV1RqqPzYxXCjCUmNK07OmjTg2wfG2yl+KOFer6Rk8C/6hWn00vPxNV7GarK1ZLMYSixMxukytDcOttkD8ERw8pkwAPBbXJKZbvSKAOYYGe9CYjT+CW8432z1MK1dihYs/u69co9bVs+m30oYsf1uDndYs2UCFF+qrmRDyKiMCe4+XVfgHuHe6pUuDzH69YjubOQCrBzEk3ZFthGaD5E6wzRoCyn7jVJ+qwR+4uYFCSMxePew+6/GEASY1aAlVH4shPRnC3JE4YmQt3hGNhPiRvVpHi0bY+qjk2eVlZ5iOqqWgoF4hi9vy5B6ahsHNJdRbZsCLdBZ++XDCxM6bdPjhrD2RsUvdk3QOkMaGmdJ6HDq3hm2S6oWszGSBwhi/EoEP2IFI5LneIcwk38D3D/R/C8oM5Xx/vchR9JPWDVgjOW1fLvyJ3qoAJ6pj2HuZfREAZ5HLUnbiMPiVa2ZnuHEc2WvdJV/VkApOXtj1kAu0A9sGgZ7HPfDIbVJCnMkWjWW1zSduXzCLtpnhOre33yn7JcBGu1DPBPHscPiQFsWOVkp7q2NmNGMQk155hLc7PtSofOb4cKh4Jr7IfxAmPQzqVMxuw/mZfw3oYsegqQDcHqMKlw8VP1JpgN4P7gMDC3Vlu7KMxFOnrzF4mTaO1rUAXXINYC2K3Yh40bik6YONJvBc8pKJyTStGrcuWT9rRrJZdgGm8CH9M0VfclY5rBge7w/3c3536bsR+UVo/P0E6CAYpzS/SQ8OjUAMcf147TswflJDePDalngEn5yi/1PvrD8GlG1DbcyS+TbyDwXWIQ2FxVqWtZTvn/JNJUHilF8tmrITkuRlGfEwFHTRYTlbUGosIBCYXGTKHH8VB2hZ5+hIzq4DKUoLzhJbzINvUIiepVp7OuuLSByZanW05rtRGq+WLzvC4PK3PuWxaDMp6Qs/0c3egqnEGATg9HQe0LA8LckmB2fZUb2eVSS17l1RyAZSe6l0khHsJsQHp0LTQaGzvuOwl5yH8VD8ch5j01JUHpu/y6qUOV7Za388AMLVKqfJMcUS5lPumKWgZThTPWa+rSO8xYZiVtlyy4FyPeoHsuqW9via2LHxpP6MbfEcsjxwsfytzSRvEcPWAjGnc1R23Y0K52kV2sfaZfCz+GBfhWCwYBi0NZRsfxF/sZJRklZPP6+/rFzeP91ZwFxrFncRYpSrfUysFqcI2wfSjuGlRmspCAHKb4iY2QCL2iaXs8dbSvR4lFwAXwzHEYunxXI9mkKoCwxHpKLQwYSQq00jJ9PI36e5nXtxIXFVYkMoLq5L8RBgE/MXEGpdoEK2dRrEQph1viKhYq38epBHKXxXFXFCcB5A+5u6FO4GxC6Nx+GZtaeCnXO2NUbZ9bxE3VMK7Ro/lvGZrJ8AThDk1V9C9jPdnvF/HerntdcqKO8hRia+GfiCne+PXgCBWeln8sFF4sD2D0onBdQi9B4K631ScW9XuUMZczRfmuzLfwWL86kaGcxJY+fPxcmmbleTnqLoU2eMCivwpvUYV8HOSB2mW/9iLRmZy9T28oF36LU3qLiV4oKZiy6zympnNJrZQ9IVVu3IiauxV12Gba+NfP0GPmFBwCM4WpPNjL9u1mivq4N8hCaW8fTX7dOOqYXe9jqcPfY27ZWPwrGIKT2pNKmakyRXaMNhZq4Z/FIpJRs4zr+e3yrYqcs44fDX4+Tdv6XbW8SV5g7F90sJcAtjbFsiohXz4X3zzA/cquqV28f7g/3GGJ9grb6idhBlWSAbAiymOhOb8meh3YxmJbhWsfC8XiUlEFVhN46gUtST+tC4BBPCxV5xgjA+XHqyhXVuaQJfLP4jqkXXaa9ogcsv7g/lIgcpGkDR8So0Y8yxaat6byt5gJzFhYngWaDOh8ADkBxm0MS3u/AdoFqjIB2x1YhJmkKYnpTghRek0yCIy6fA6VKxjq8+6HesoLBBiH5TwPy3F3+vanG46psLg8PJR9RmekXNvnoegELuEZ4fUKaAzVRSGN9QueD4JG2vf9V3kPO0wEHnmoSn5wzng//eV0wKxxetmDT4/4iQu4+HJ0hWAW1NUYkiCXclwKpU5J+DDQwlQYyk9svSQlGeB1/vmfaircNDUBwWxozBV96RapF6wtpUij0wqVMYSDFCkNbzYxMk1P5oNyp8PH/45oiKq7SPZLHz0AQtVMBpZ/qX+KyMT34/1lPAnZyXsEKEvctuzRIFfwLkgj9GBll7z7EAnOLqXgWPGvbSOUOb2hR6mlqJvEYxJpHW6sb5eiNA5iIM0URRoEGdCsxbZErQGqCXDuNou1YBmJqArK0U8IrgopNNIPpATg37Wu4oUqhzbu0E9aKBhOlbD4UpLvTEUZuiYDlUy4PevQc074SuCsLRyVhLH+F86BVi03+4x7kk9uiXPPN2YykQTs5JG/Xhq6U2G/2xUp4WiU4t/XAhlDnr98uW5/6m5MChnwNRARFE/+lVKADvQFVHZ1SQ/9FkzJmIsyQLHBsIEyi45y4dVe/k7mUtEjKuHREGVPsNzfCu8iNbMUzEuNVDBirm/pJv3Ec68t+2j+4FyepusfFDP3RW/fHKaSbJNaJu5ZDvSgRJtC0yfCyUYzGkJ7tOtpzwJZGa3HbZIjq8/nmtTChSKb05BI/iNhes2Z0pmzGDKTDQ6dWVkVZugYlkIYorgSSajNam2T/lvXmxXhjIPpG69Bs0X3CdG893zmdeVZ9yppnctLhvaFSzONyrGyv5BspUlC/roRwmxPXRIqU+LpFNheuOLqTv1Du+Ovh0yCc9fpZrtd+56MVsQrd+xJVeda9jq4FWMkWNa66bfVlwJau9YABj4ROVrYz7d8DeDBhOUB5ILhHScLZfxBSFFXtm0dK4e3L8gA2IfQUv4/TZ3NNhKbk+hMTumJHHdo/HcrGgNPOxHBtS3J8bd4ONa2bc/3Cr1NEFjjxNDG6dr6ZtY5ygg==',
        salt = '34d50565ba416b013d352de59a4198fc',
        isRememberEnabled = true,
        rememberDurationInDays = 0; // 0 means forever

    // constants
    var rememberPassphraseKey = 'staticrypt_passphrase',
        rememberExpirationKey = 'staticrypt_expiration';

    /**
     * Decrypt a salted msg using a password.
     * Inspired by https://github.com/adonespitogo
     *
     * @param  encryptedMsg
     * @param  hashedPassphrase
     * @returns 
     */
    function decryptMsg(encryptedMsg, hashedPassphrase) {
        var iv = CryptoJS.enc.Hex.parse(encryptedMsg.substr(0, 32))
        var encrypted = encryptedMsg.substring(32);

        return CryptoJS.AES.decrypt(encrypted, hashedPassphrase, {
            iv: iv,
            padding: CryptoJS.pad.Pkcs7,
            mode: CryptoJS.mode.CBC
        }).toString(CryptoJS.enc.Utf8);
    }

    /**
     * Decrypt our encrypted page, replace the whole HTML.
     *
     * @param  hashedPassphrase
     * @returns 
     */
    function decryptAndReplaceHtml(hashedPassphrase) {
        var encryptedHMAC = encryptedMsg.substring(0, 64),
            encryptedHTML = encryptedMsg.substring(64),
            decryptedHMAC = CryptoJS.HmacSHA256(encryptedHTML, CryptoJS.SHA256(hashedPassphrase).toString()).toString();

        if (decryptedHMAC !== encryptedHMAC) {
            return false;
        }

        var plainHTML = decryptMsg(encryptedHTML, hashedPassphrase);

        document.write(plainHTML);
        document.close();

        return true;
    }

    /**
     * Salt and hash the passphrase so it can be stored in localStorage without opening a password reuse vulnerability.
     *
     * @param  passphrase
     * @returns 
     */
    function hashPassphrase(passphrase) {
        return CryptoJS.PBKDF2(passphrase, salt, {
            keySize: 256 / 32,
            iterations: 1000
        }).toString();
    }

    /**
     * Clear localstorage from staticrypt related values
     */
    function clearLocalStorage() {
        localStorage.removeItem(rememberPassphraseKey);
        localStorage.removeItem(rememberExpirationKey);
    }

    // try to automatically decrypt on load if there is a saved password
    window.onload = function () {
        if (isRememberEnabled) {
            // show the remember me checkbox
            document.getElementById('staticrypt-remember-label').classList.remove('hidden');

            // if we are login out, clear the storage and terminate
            var queryParams = new URLSearchParams(window.location.search);

            if (queryParams.has("staticrypt_logout")) {
                return clearLocalStorage();
            }

            // if there is expiration configured, check if we're not beyond the expiration
            if (rememberDurationInDays && rememberDurationInDays > 0) {
                var expiration = localStorage.getItem(rememberExpirationKey),
                    isExpired = expiration && new Date().getTime() > parseInt(expiration);

                if (isExpired) {
                    return clearLocalStorage();
                }
            }

            var hashedPassphrase = localStorage.getItem(rememberPassphraseKey);

            if (hashedPassphrase) {
                // try to decrypt
                var isDecryptionSuccessful = decryptAndReplaceHtml(hashedPassphrase);

                // if the decryption is unsuccessful the password might be wrong - silently clear the saved data and let
                // the user fill the password form again
                if (!isDecryptionSuccessful) {
                    return clearLocalStorage();
                }
            }
        }
    }

    // handle password form submission
    document.getElementById('staticrypt-form').addEventListener('submit', function (e) {
        e.preventDefault();

        var passphrase = document.getElementById('staticrypt-password').value,
            shouldRememberPassphrase = document.getElementById('staticrypt-remember').checked;

        // decrypt and replace the whole page
        var hashedPassphrase = hashPassphrase(passphrase);
        var isDecryptionSuccessful = decryptAndReplaceHtml(hashedPassphrase);

        if (isDecryptionSuccessful) {
            // remember the hashedPassphrase and set its expiration if necessary
            if (isRememberEnabled && shouldRememberPassphrase) {
                window.localStorage.setItem(rememberPassphraseKey, hashedPassphrase);

                // set the expiration if the duration isn't 0 (meaning no expiration)
                if (rememberDurationInDays > 0) {
                    window.localStorage.setItem(
                        rememberExpirationKey,
                        (new Date().getTime() + rememberDurationInDays * 24 * 60 * 60 * 1000).toString()
                    );
                }
            }
        } else {
            alert('Bad passphrase!');
        }
    });
</script>
</body>
</html>
