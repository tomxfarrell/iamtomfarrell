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
    var encryptedMsg = '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',
        salt = 'b11ea793a3075ce99feb1cda332a7ab6',
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
