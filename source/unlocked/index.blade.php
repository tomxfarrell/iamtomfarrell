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
            background: #76b852; /* fallback for old browsers */
            background: -webkit-linear-gradient(right, #76b852, #8DC26F);
            background: -moz-linear-gradient(right, #76b852, #8DC26F);
            background: -o-linear-gradient(right, #76b852, #8DC26F);
            background: linear-gradient(to left, #76b852, #8DC26F);
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
    var encryptedMsg = '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',
        salt = '95f9d701d45fa6f743e27a669bcb4c30',
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
